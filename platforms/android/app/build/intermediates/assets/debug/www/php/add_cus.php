<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_POST['cus_name'];   
    $phone  = $_POST['phone'];   
    $addr  = $_POST['addr'];  
    $type = $_POST['type']; 
   
    $sql = "INSERT INTO customer (cus_name,cus_tel,cus_addr,cus_type) VALUE ('$name','$phone','$addr','$type')"; 
    $result = mysqli_query($conn, $sql); 

    if($result){
        echo "success";    
    }else{
        echo "connection fail or name is not unique!";  
    }	
	mysqli_close($conn);
?>