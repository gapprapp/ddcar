<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $cus_id  = $_POST['cus_id'];   
    $name  = $_POST['cus_name'];   
    $phone  = $_POST['phone'];   
    $addr  = $_POST['addr'];    
    $type = $_POST['type'];
  
    $sql = "UPDATE customer SET cus_name = '$name',cus_tel = '$phone',cus_addr = '$addr',cus_type = '$type' WHERE cus_id = '$cus_id'"; 
    $result = mysqli_query($conn, $sql); 

    if($result){
        echo "success";       
    }else{
        echo "connection fail or name is not unique!";   
    }	
	mysqli_close($conn);
?>