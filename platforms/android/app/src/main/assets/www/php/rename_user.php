<?php
    include "db.php";
    $user_id  = $_POST['user_id'];   
    $role  = $_POST['role'];

    $sql = "UPDATE user SET user_role = '$role' WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
            
    if($result){
        echo "success";       
    }else{        
        echo "fail";      
    }    
    mysqli_close($conn);
?>