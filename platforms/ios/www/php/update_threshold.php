<?php
    include "db.php";
    $prod_id  = $_POST['prod_id'];   
    $amt  = $_POST['amt']; 
    $del  = $_POST['del'];
   
    $sql = "UPDATE product SET min_amount = '$amt',day_transport = '$del' WHERE prod_id = '$prod_id'"; 
    $result = mysqli_query($conn, $sql);   

    if($result){
        echo "success";         
    }else{
        echo "fail";        
    }
    mysqli_close($conn);
?>