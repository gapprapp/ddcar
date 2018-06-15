<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_POST['name'];   
    $old_name  = $_POST['old_name'];

    $sql = "UPDATE tree SET title = '$name' WHERE title = '$old_name'";
    $result = mysqli_query($conn, $sql);
            
    if($result){
        echo "success";      
    }else{
        echo "fail";      
    }    
    mysqli_close($conn);
?>