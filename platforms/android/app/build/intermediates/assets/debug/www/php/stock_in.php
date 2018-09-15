<?php
    include "db.php";
    $input  = $_POST['JSON'];
    $obj = json_decode($input,true);  	
    $ware_id  = $_POST['ware_id'];   
    $dt  = $_POST['date']; 
    $sum  = $_POST['sum']; 
    $user_id  = $_POST['user_id'];
    $last_id = "";
    $i = 0;

    mysqli_begin_transaction($conn);
    $sql = "SELECT stock_number,count FROM stock_in ORDER BY stock_id DESC LIMIT 1"; 
    $result = mysqli_query($conn, $sql);   
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){  
            $number = $row['stock_number'];
            $year_old = substr($number,3,2);
            $year_cur = date("y");
            if($year_cur == $year_old){
                $count = $row['count']+1;
                $year = "IMP" . $year_cur . "-";
                $stock_number = $year . str_pad($count, 5, "0",STR_PAD_LEFT);
                $sql2 = "INSERT INTO stock_in (stock_number,date_time,ware_id,user_id,total_stock,count) 
                VALUES ('$stock_number','$dt','$ware_id','$user_id','$sum','$count')"; 
                $result2 = mysqli_query($conn, $sql2);
                $last_id = mysqli_insert_id($conn);	
                if(!$result2){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                } 
            }else{
                $year = "IMP" . $year_cur . "-";
                $stock_number = $year . str_pad(1, 5, "0",STR_PAD_LEFT);
                $sql3 = "INSERT INTO stock_in (stock_number,date_time,ware_id,user_id,total_stock,count) 
                VALUES ('$stock_number','$dt','$ware_id','$user_id','$sum',1)"; 
                $result3 = mysqli_query($conn, $sql3);
                $last_id = mysqli_insert_id($conn);	
                if(!$result3){
                    mysqli_rollback($conn);
                    echo "fail";
                    exit;
                } 
            }           
        }
    }else{
        $year = "IMP" . date("y") . "-";
        $stock_number = $year . str_pad(1, 5, "0",STR_PAD_LEFT);
        $sql1 = "INSERT INTO stock_in (stock_number,date_time,ware_id,user_id,total_stock,count) 
        VALUES ('$stock_number','$dt','$ware_id','$user_id','$sum',1)"; 
        $result1 = mysqli_query($conn, $sql1);
        $last_id = mysqli_insert_id($conn);	
        if(!$result1){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        } 
    }   
    foreach ($obj as $data)
    {
        $i++;
        $item = $i;
        $prod_id = $data['prod_id'];
        $cost = $data['cost'];    
        $amt = $data['amt'];  
        $addr = $data['addr']; 

        $sql_item = "INSERT INTO stock_in_item (stock_id,item_id,prod_id,stock_cost,amount) VALUE ('$last_id','$item','$prod_id','$cost','$amt')"; 
        $result_item = mysqli_query($conn, $sql_item);
        if(!$result_item){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        } 
        
        $query = "SELECT prod_id FROM warehouse WHERE ware_id = '$ware_id' AND prod_id = '$prod_id'";
        $result_q = mysqli_query($conn, $query);
        if(mysqli_num_rows($result_q) > 0){ 
            $sql = "UPDATE warehouse SET amount = amount+'$amt' WHERE ware_id = '$ware_id' AND prod_id = '$prod_id'";          
        }else{
            $sql = "INSERT INTO warehouse (ware_id,prod_id,amount) VALUE ('$ware_id','$prod_id','$amt')";           
        }
        $result = mysqli_query($conn, $sql);
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }
        if($addr != ""){
            $sql = "INSERT INTO warehouse_place (ware_id,prod_id,place) VALUE ('$ware_id','$prod_id','$addr')"; 
            $result = mysqli_query($conn, $sql); 
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }            
        }       
    }
    mysqli_commit($conn); 
    echo "success"; 
    mysqli_close($conn);
?>