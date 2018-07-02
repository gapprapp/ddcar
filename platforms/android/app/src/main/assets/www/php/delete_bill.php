<?php  
    include "db.php"; 
    $bill_id  = $_POST['bill_id'];
    $txt = "(cancel)";

    $query = "SELECT branch_id,type FROM sale_order WHERE order_id = '$bill_id'";  
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            $branch_id = $row['branch_id'];
            $type = $row['type'];
        }   
    } 

    mysqli_begin_transaction($conn);
    $query = "SELECT prod_amount,prod_id FROM sale_order_item WHERE order_id = '$bill_id'";  
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            $amt = $row['prod_amount']; 
            $prod_id = $row['prod_id']; 
            if($type == "โกดัง"){
                $query = "UPDATE warehouse SET amount=amount+'$amt' WHERE ware_id = '$branch_id' AND prod_id = '$prod_id'";  
            }else if($type == "หน้าร้าน"){
                $query = "UPDATE shop SET amount=amount+'$amt' WHERE shop_id = '$branch_id' AND prod_id = '$prod_id'";  
            }            
            $result1 = mysqli_query($conn, $query); 
            if(!$result1){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }              
        }   
    } 
  
    $sql = "UPDATE sale_order SET order_number = CONCAT(order_number,'".$txt."') WHERE order_id = '$bill_id'";  
    $result = mysqli_query($conn, $sql); 
    if(!$result){
        mysqli_rollback($conn);
        echo "fail";
        exit;
    }        
    mysqli_commit($conn);
    echo "success"; 
    mysqli_close($conn);
?>