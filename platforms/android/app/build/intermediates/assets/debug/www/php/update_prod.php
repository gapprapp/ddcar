<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $prod_id  = $_POST['prod'];   
    $cost  = $_POST['cost']; 
    $price_s  = $_POST['price_s'];   
    $price_w  = $_POST['price_w']; 

    mysqli_autocommit($conn,FALSE); 
    $sql = "UPDATE product SET prod_cost = '$cost',prod_pricesend = '$price_s',prod_price = '$price_w' 
    WHERE prod_id = '$prod_id'"; 
    $result = mysqli_query($conn, $sql);   

    if($result){
        echo "success";
        mysqli_commit($conn);          
    }else{
        echo "fail";
        mysqli_rollback($conn);
    }

    mysqli_close($conn);
?>