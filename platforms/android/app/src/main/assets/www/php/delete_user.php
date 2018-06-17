<?php  
    include "db.php"; 
    $name  = $_POST['name'];
  
    $sql = "DELETE FROM user WHERE user_name = '$name'";
    $result = mysqli_query($conn, $sql);      
        
    if($result){
        echo "success";       
    }else{
        echo "fail";      
    }    
    mysqli_close($conn);
?>