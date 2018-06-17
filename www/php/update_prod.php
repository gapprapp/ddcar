<?php
    include "db.php";
    $prod_id  = $_POST['prod'];   
    $cost  = $_POST['cost']; 
    $price_s  = $_POST['price_s'];   
    $price_w  = $_POST['price_w'];
   
    $sql = "UPDATE product SET prod_cost = '$cost',prod_pricesend = '$price_s',prod_price = '$price_w' 
    WHERE prod_id = '$prod_id'"; 
    $result = mysqli_query($conn, $sql);   

    if($result){
        echo "success";              
    }else{
        echo "fail";      
    }
    mysqli_close($conn);
?>