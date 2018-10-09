<?php
    include "db.php";
    
    $query = "SELECT * FROM customer LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){    
      while($row = mysqli_fetch_array($result)){      
        echo $row['cus_name'];
      }   
    }

    if($result){
        echo "success";
    }else{
        echo "fail";
    } 
    mysqli_close($conn);
?>