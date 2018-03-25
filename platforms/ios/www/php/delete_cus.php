<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $cus_id  = $_POST['cus_id'];

    mysqli_autocommit($conn,FALSE);   
    $sql = "DELETE FROM customer WHERE cus_id = '$cus_id'";
    $result = mysqli_query($conn, $sql);      
    $sql = "DELETE FROM detail_cus WHERE cus_id = '$cus_id'";
    $result = mysqli_query($conn, $sql);      
        
    if($result){
        echo "success";
        mysqli_commit($conn);
    }else{
        echo "fail";
        mysqli_rollback($conn);
    }    
    mysqli_close($conn);
?>