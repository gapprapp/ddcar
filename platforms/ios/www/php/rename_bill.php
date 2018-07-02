<?php  
    include "db.php";
    $input  = $_POST['JSON'];
    $obj = json_decode($input,true); 
    $bill_id = $_POST['bill_id'];
    $pay = $_POST['pay'];
    $sum = $_POST['sum'];
    $dis = $_POST['dis'];
    $total = $_POST['total'];
    $get = $_POST['get'];
    $chng = $_POST['chng'];

    $query = "SELECT * FROM sale_order WHERE order_id = '$bill_id'";  
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            $summ = $row['sum_price'];
            $payy = $row['paymemt_type'];
            $diss = $row['total_discount'];
            $totall = $row['total_price'];
            $gett = $row['get_price'];
            $chngg = $row['chng'];
            $b_id = $row['branch_id'];
            $type_b = $row['type'];
        }   
    }

    mysqli_begin_transaction($conn);
    $query = "INSERT INTO order_record(order_id,sum_price,total_discount,total_price,get_price,chng,payment_type,branch_id,type) 
    VALUES ('$bill_id','$summ','$diss','$totall','$gett','$chngg','$payy','$b_id','$type_b')";  
    $result = mysqli_query($conn, $query);  
    if(!$result){
        mysqli_rollback($conn);
        echo "fail";
        exit;
    }      

    $query = "UPDATE sale_order SET sum_price = '$sum',payment_type = '$pay',total_discount = '$dis',
    total_price = '$total',get_price = '$get',chng = '$chng' WHERE order_id = '$bill_id'";  
    $result = mysqli_query($conn, $query);
    if(!$result){
        mysqli_rollback($conn);
        echo "fail";
        exit;
    }

    foreach ($obj as $data){
        $no = $data['item_id'];
        $amt = $data['amt'];

        $query = "SELECT * FROM sale_order_item WHERE order_id = '$bill_id' AND item_id='$no'";  
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){    
            while($row = mysqli_fetch_array($result)){
                $prod_id = $row['prod_id'];
                $price = $row['prod_price'];
                $amount = $row['prod_amount'];
            }   
        } 

        $query = "INSERT INTO order_record_item(order_id,item_id,prod_id,prod_price,prod_amount) 
        VALUES ('$bill_id','$no','$prod_id','$price','$amount')";  
        $result = mysqli_query($conn, $query); 
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }      
        
        if($type_b == "โกดัง"){
            if($amount > $amt){
                $dif = $amount - $amt;            
                $query = "UPDATE warehouse SET amount=amount+'$dif' WHERE ware_id = '$b_id' AND prod_id = '$prod_id'";  
            }else if($amt > $amount){
                $dif = $amt - $amount;
                $query = "UPDATE warehouse SET amount=amount-'$dif' WHERE ware_id = '$b_id' AND prod_id = '$prod_id'";  
            }     
        }else if($type_b == "หน้าร้าน"){
            if($amount > $amt){
                $dif = $amount - $amt;            
                $query = "UPDATE shop SET amount=amount+'$dif' WHERE shop_id = '$b_id' AND prod_id = '$prod_id'";  
            }else if($amt > $amount){
                $dif = $amt - $amount;
                $query = "UPDATE shop SET amount=amount-'$dif' WHERE shop_id = '$b_id' AND prod_id = '$prod_id'";  
            }     
        }           
        $result = mysqli_query($conn, $query);
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }        

        $query = "UPDATE sale_order_item SET prod_amount='$amt' WHERE order_id = '$bill_id' AND item_id='$no'";  
        $result = mysqli_query($conn, $query);
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }
    }
    mysqli_commit($conn);
    echo "success"; 
    mysqli_close($conn);
?>