<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_POST['cus_name'];   
    $phone  = $_POST['phone'];   
    $addr  = $_POST['addr'];    

    mysqli_autocommit($conn,FALSE); 
    $sql = "INSERT INTO customer (cus_name,cus_tel,cus_addr) VALUE ('$name','$phone','$addr')"; 
    $result = mysqli_query($conn, $sql); 

    if($result){
        echo "success";
        mysqli_commit($conn);          
    }else{
        echo "connection fail or name is not unique!";
        mysqli_rollback($conn);
    }
	
	mysqli_close($conn);
?>