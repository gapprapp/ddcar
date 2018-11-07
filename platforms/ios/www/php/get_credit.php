<?php
    include "db.php";
    $output = array();    
   
    $query = "SELECT s.customer_id,c.cus_name,s.total_price,s.date_time FROM sale_order s INNER JOIN customer c
    ON s.customer_id = c.cus_id WHERE s.order_number NOT LIKE '%(cancel)%' AND s.payment_type LIKE '%เครดิต%' 
    AND s.payment_type NOT LIKE '%หมดอายุ%'";
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