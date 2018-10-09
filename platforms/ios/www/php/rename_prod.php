<?php
    include "db.php";   
    $prod_id  = $_POST['prod_id'];
    $name  = $_POST['name_prod'];
    $code  = $_POST['code'];   
    $cost  = $_POST['cost'];
    $price_w  = $_POST['price_w'];
    $price_s  = $_POST['price_s'];
    $img  = $_POST['img'];
    $min = $_POST['min'];
    //$b64 = str_replace(" ","+",$img);
    if($img == 1){
        $sql = "UPDATE product SET prod_name = '$name',prod_code = '$code',prod_price = '$price_w',
        prod_pricesend = '$price_s',prod_cost = '$cost',min_amount = '$min' WHERE prod_id = '$prod_id'";  
    }else{
        $sql = "UPDATE product SET prod_name = '$name',prod_code = '$code',prod_price = '$price_w',
        prod_pricesend = '$price_s',prod_cost = '$cost',img = '$img',min_amount = '$min' WHERE prod_id = '$prod_id'";
    }  
    $result = mysqli_query($conn, $sql);

    if($result){
        echo "success";
    }else{
        echo "fail";
    }    
    mysqli_close($conn);
?>