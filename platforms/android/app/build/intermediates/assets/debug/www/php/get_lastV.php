<?php
    include "db.php";   
  
    $sql = "SELECT url FROM version"; 
    $result = mysqli_query($conn, $sql);    
   
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            echo $row['url'];
        }
    }else{
       echo "fail";
    } 
    mysqli_close($conn);
?>