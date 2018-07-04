<?php
    include "db.php";
    $imp_id = $_POST['imp_id'];

    $query = "SELECT s.stock_number,s.ware_id,w.ware_name,s.date_time,s.total_stock,i.item_id,i.prod_id,p.prod_name,i.stock_cost,i.amount 
    FROM stock_in s INNER JOIN warehouse_detail w ON s.ware_id = w.ware_id INNER JOIN stock_in_item i ON s.stock_id = i.stock_id 
    INNER JOIN product p ON i.prod_id = p.prod_id WHERE s.stock_id = '$imp_id'";
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