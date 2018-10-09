<?php  
    include "db.php";
    $cus_id  = $_POST['cus_id'];

    mysqli_begin_transaction($conn);
    $sql = "DELETE FROM customer WHERE cus_id = '$cus_id'";
    $result = mysqli_query($conn, $sql);    
    if(!$result){
        mysqli_rollback($conn);
        echo "fail";
        exit;
    }    
    $sql = "DELETE FROM detail_cus WHERE cus_id = '$cus_id'";
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