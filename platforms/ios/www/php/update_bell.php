<?php
    include "db.php";   
  
    $sql = "UPDATE bell SET status = 'normal'";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "success";
    }else{
        echo "fail";
    }  
    mysqli_close($conn);
?>