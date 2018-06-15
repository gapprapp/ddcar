<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
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