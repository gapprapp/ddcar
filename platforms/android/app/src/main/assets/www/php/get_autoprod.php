<?php
    include "db.php";
    $prod_id = $_POST['prod_id'];   
    $output = array(); 
   
    $query = "SELECT prod_id,prod_name,prod_code,prod_price,prod_pricesend,prod_cost FROM product";     
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
      //ini_set('memory_limit', '-1');
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