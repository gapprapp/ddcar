<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_POST['user']; 
    $pass  = $_POST['pass'];   
    $phone  = $_POST['phone'];   
    $role  = $_POST['role'];   

    mysqli_autocommit($conn,FALSE); 
    $sql = "INSERT INTO user (user_name,pass,phone,user_role) VALUE ('$name','$pass','$phone','$role')"; 
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