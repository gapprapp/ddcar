<?php
    include "db.php";
    $input  = $_POST['JSON'];
    $obj = json_decode($input,true); 
    $input_d  = $_POST['JSOND'];
    $obj_d = json_decode($input_d,true); 
    $cus  = $_POST['cus_id'];
    $b  = $_POST['ware_id'];
    $dt  = $_POST['date'];
    $sum  = $_POST['net'];
    $pay  = $_POST['pay'];
    $dis  = $_POST['dis'];
    $type = $_POST['type'];
    $get  = $_POST['get_price'];
    $change  = $_POST['chng'];
    $total  = $_POST['total'];
    //$comment  = $_POST['comment'];
    //$name_cus = $_POST['name_cus'];
    $user_id = $_POST['user_id'];

    mysqli_begin_transaction($conn);
    foreach ($obj_d as $data)
    {        
        $prod_id = $data['prod_id'];
        $price = $data['price'];   
      
        $sql = "SELECT * FROM detail_cus WHERE prod_id = '$prod_id' AND cus_id = '$cus'"; 
        $result = mysqli_query($conn, $sql);    
        if(mysqli_num_rows($result) > 0){   
            $sql = "UPDATE detail_cus SET prod_id = '$prod_id',cus_id = '$cus',cus_price = '$price')"; 
        }else{
            $sql = "INSERT INTO detail_cus(prod_id,cus_id,cus_price) VALUE ('$prod_id','$cus','$price')"; 
        }        
        $result = mysqli_query($conn, $sql);  
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }        
    }
    $sql = "SELECT order_number,count FROM sale_order ORDER BY order_id DESC LIMIT 1"; 
    $result = mysqli_query($conn, $sql);    
   
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){  
            $number = $row['order_number'];
            $year_old = substr($number,1,2);
            $year_cur = date("y");
            if($year_cur == $year_old){
                $count = $row['count']+1;
                $year = "S" . $year_cur . "-";
                $order_number = $year . str_pad($count, 5, "0",STR_PAD_LEFT);
                $sql2 = "INSERT INTO sale_order (order_number,customer_id,date_time,sum_price,
                payment_type,branch_id,type,total_discount,total_price,get_price,chng,user_id,count) 
                VALUE ('$order_number','$cus','$dt','$sum','$pay','$b','$type','$dis','$total','$get','$change','$user_id','$count')"; 
                $result2 = mysqli_query($conn, $sql2);
                if(!$result2){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                }
                $last_id = mysqli_insert_id($conn);	
            }else{
                $year = "S" . $year_cur . "-";
                $order_number = $year . str_pad(1, 5, "0",STR_PAD_LEFT);
                $sql3 = "INSERT INTO sale_order (order_number,customer_id,date_time,sum_price,
                payment_type,branch_id,type,total_discount,total_price,get_price,chng,user_id,count) 
                VALUE ('$order_number','$cus','$dt','$sum','$pay','$b','$type','$dis','$total','$get','$change','$user_id',1)"; 
                $result3 = mysqli_query($conn, $sql3);
                if(!$result3){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                }
                $last_id = mysqli_insert_id($conn);	
            }           
        }
    }else{
        $year = "S" . date("y") . "-";
        $order_number = $year . str_pad(1, 5, "0",STR_PAD_LEFT);
        $sql1 = "INSERT INTO sale_order (order_number,customer_id,date_time,sum_price,
        payment_type,branch_id,type,total_discount,total_price,get_price,chng,user_id,count) 
        VALUE ('$order_number','$cus','$dt','$sum','$pay','$b','$type','$dis','$total','$get','$change','$user_id',1)"; 
        $result1 = mysqli_query($conn, $sql1);
        if(!$result1){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }
        $last_id = mysqli_insert_id($conn);	
    }  
    $item = 0;
    $ch = 'false'; 
    foreach ($obj as $data)
    {
        $item++;
        $prod_id = $data['prod_id'];
        $price = $data['price'];    
        $amt = $data['amt'];    
        $amount = 0;
      
        $sql1 = "INSERT INTO sale_order_item (order_id,item_id,prod_id,prod_price,prod_amount)
         VALUE ('$last_id','$item','$prod_id','$price','$amt')"; 
        $result1 = mysqli_query($conn, $sql1);  
        if(!$result1){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        } 

        $sql = "SELECT min_amount,status FROM product WHERE prod_id = '$prod_id' AND status != 'danger'"; 
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){    
            while($row = mysqli_fetch_array($result)){  
                $min = $row['min_amount'];
                $status = $row['status'];
            }
        }
        
        $sql = "SELECT amount FROM warehouse WHERE prod_id = '$prod_id'"; 
        $result = mysqli_query($conn, $sql); 
        if(mysqli_num_rows($result) > 0){    
            while($row = mysqli_fetch_array($result)){  
                $amount += $row['amount'];                    
            }
        } 
        $sql = "SELECT amount FROM shop WHERE prod_id = '$prod_id'"; 
        $result = mysqli_query($conn, $sql); 
        if(mysqli_num_rows($result) > 0){    
            while($row = mysqli_fetch_array($result)){  
                $amount += $row['amount'];                    
            }
        } 
        if($status == 'normal'){            
            if($amount - $amt <= 10){
                $sql = "UPDATE product SET status = 'danger' WHERE prod_id = '$prod_id'";
                $result = mysqli_query($conn, $sql);
                $ch = 'true';    
                if(!$result){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                }    
            }else if($amount - $amt <= $min){
                $sql = "UPDATE product SET status = 'warning' WHERE prod_id = '$prod_id'";
                $result = mysqli_query($conn, $sql); 
                $ch = 'true';    
                if(!$result){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                } 
            }
        }else if($status == 'warning'){
            if($amount - $amt <= 10){
                $sql = "UPDATE product SET status = 'danger' WHERE prod_id = '$prod_id'";
                $result = mysqli_query($conn, $sql);
                $ch = 'true';    
                if(!$result){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                }    
            }
        }       
       
        if($type == "โกดัง"){
            $sql_up = "UPDATE warehouse SET amount = amount-'$amt' WHERE ware_id = '$b' AND prod_id = '$prod_id'"; 
        }else if($type == "หน้าร้าน"){
            $sql_up = "UPDATE shop SET amount = amount-'$amt' WHERE shop_id = '$b' AND prod_id = '$prod_id'"; 
        }       
        $result_up = mysqli_query($conn, $sql_up);    
        if(!$result_up){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }    
    }
    if($ch == true){
        $sql = "UPDATE bell SET status = 'alert'";
        $result = mysqli_query($conn, $sql);       
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }         
    }
    mysqli_commit($conn); 
    echo $order_number." ".$ch;
    mysqli_close($conn);
?>