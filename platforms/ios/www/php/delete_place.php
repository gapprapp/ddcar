<?php
    include "db.php";
    $prod_id = $_POST['prod_id'];    

    if(isset($_POST['shop_id'])){
        $shop_id = $_POST['shop_id'];    
        $query = "DELETE FROM shop_place WHERE prod_id = '$prod_id' AND shop_id = '$shop_id'";
    }else if(isset($_POST['ware_id'])){
        $ware_id = $_POST['ware_id']; 
        $query = "DELETE FROM warehouse_place WHERE prod_id = '$prod_id' AND ware_id = '$ware_id'";
    }    
    $result = mysqli_query($conn, $query);   

    if($result){
        echo "success";
    }else{
        echo "fail";
    }
	mysqli_close($conn);
?>