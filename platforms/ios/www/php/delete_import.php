<?php  
    include "db.php"; 
    $imp_id  = $_POST['imp_id'];
    $ware_id  = $_POST['ware_id'];
    $txt = "(cancel)"; 

    mysqli_begin_transaction($conn);
    $query = "SELECT amount,prod_id FROM stock_in_item WHERE stock_id = '$imp_id'";  
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            $amt = $row['amount']; 
            $prod_id = $row['prod_id'];           
            $query = "UPDATE warehouse SET amount=amount-'$amt' WHERE ware_id = '$ware_id' AND prod_id = '$prod_id'";                 
            $result1 = mysqli_query($conn, $query); 
            if(!$result1){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }              
        }   
    }
  
    $sql = "UPDATE stock_in SET stock_number = CONCAT(stock_number,'".$txt."') WHERE stock_id = '$imp_id'";  
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