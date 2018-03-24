<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_POST['name']; 
    $type  = $_POST['type'];
    
    if($type == "โกดัง"){
        $sql = "INSERT INTO warehouse_detail (ware_name) VALUE ('$name')"; 
    }else if($type == "หน้าร้าน"){
        $sql = "INSERT INTO shop_detail (shop_name) VALUE ('$name')"; 
    }   
    $result = mysqli_query($conn, $sql);    

    if($result){
        echo "success";       
    }else{
        echo "connection fail or name is not unique!";        
    }	
	mysqli_close($conn);
?>