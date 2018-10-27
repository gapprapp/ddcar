<?php
    include "db.php";   
    $prod_id  = $_POST['prod_id'];
    $name  = $_POST['name_prod'];
    $code  = $_POST['code'];
    // $code  = $_POST['code'];   
    // $cost  = $_POST['cost'];
    // $price_w  = $_POST['price_w'];
    // $price_s  = $_POST['price_s'];
     
    // $min = $_POST['min']; 
   
    if(isset($_POST['img'])){
        $img  = $_POST['img'];
        $sql = "UPDATE product SET prod_name = '$name',prod_code = '$code',img = '$img' WHERE prod_id = '$prod_id'";
    }else{
        $sql = "UPDATE product SET prod_name = '$name',prod_code = '$code' WHERE prod_id = '$prod_id'";
    }
    $result = mysqli_query($conn, $sql);
  
    if($result){
        echo "success";
    }else{
        echo "fail";
    }    
    mysqli_close($conn);
?>