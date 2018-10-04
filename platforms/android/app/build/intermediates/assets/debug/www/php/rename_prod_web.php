<?php
    include "db.php";   
    $prod_id  = $_POST['prod_id'];
    $name  = $_POST['name_prod'];
    // $code  = $_POST['code'];   
    // $cost  = $_POST['cost'];
    // $price_w  = $_POST['price_w'];
    // $price_s  = $_POST['price_s'];
    // $img  = $_POST['img'];
    // $min = $_POST['min']; 
   
    $sql = "UPDATE product SET prod_name = '$name' WHERE prod_id = '$prod_id'";     
    $result = mysqli_query($conn, $sql);

    if($result){
        echo "success";
    }else{
        echo "fail";
    }    
    mysqli_close($conn);
?>