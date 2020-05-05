<?php
    include "db.php";
    $cus_id = $_POST['cus_id'];   
    $prod_id = $_POST['prod_id'];
    $output = array();       
    
    $query = "SELECT cus_price FROM detail_cus WHERE prod_id = '$prod_id' AND cus_id = '$cus_id'"; 
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