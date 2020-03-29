<?php
    include "db.php";    
    $ware_id = $_POST['ware_id'];
    $type = $_POST['type'];
    $prod_id = $_POST['prod_id'];
    $output = array();   
       
    if($type == "โกดัง"){
        $query = "SELECT amount FROM warehouse WHERE prod_id = '$prod_id' AND ware_id = '$ware_id'";
    }else if($type == "หน้าร้าน"){
        $query = "SELECT amount FROM shop WHERE prod_id = '$prod_id' AND shop_id = '$ware_id'";
    }        
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            $output[] = $row;                  
        }   
    }

    if($result){
        echo json_encode($output);		   
    }else{
        echo "fail";
    }
    mysqli_close($conn);
?>