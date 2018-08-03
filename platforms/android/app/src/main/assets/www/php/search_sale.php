<?php
    include "db.php";
    $data = $_POST['phrase'];
    $cus_id = $_GET['cus_id'];
    $output = array();
      
    $query = "SELECT * FROM product WHERE prod_name LIKE '%$data%' OR prod_code LIKE '%$data%'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){      
            $prod_id = $row['prod_id']; 
            $query = "SELECT cus_price FROM detail_cus WHERE prod_id = '$prod_id' AND cus_id = '$cus_id'"; 
            $result1 = mysqli_query($conn, $query);   
            if(mysqli_num_rows($result1) > 0){    
                while($row1 = mysqli_fetch_array($result1)){ 
                    $cus_price = $row1['cus_price'];
                    array_push($row,$cus_price);              
                }   
              } 
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