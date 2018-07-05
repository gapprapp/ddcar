<?php
    include "db.php";
    $output = array();
    $txt = "(cancel)";
   
    $query = "SELECT s.order_id,c.cus_name,s.date_time,s.payment_type,s.total_price FROM sale_order s INNER JOIN customer c
    ON s.customer_id = c.cus_id WHERE s.order_number NOT LIKE '%$txt%' AND s.payment_type LIKE 'เครดิต%'";
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