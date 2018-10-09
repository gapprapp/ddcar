<?php
    include "db.php";
    $cus_id = $_POST['cus_id'];
    $cd = $_POST['cd'];
    $date = date("Y-m");

    if($cd == "เลย"){
        $query = "SELECT s.order_id,s.order_number,c.cus_name,s.total_price,s.date_time,s.payment_type 
        FROM sale_order s INNER JOIN customer c ON s.customer_id = c.cus_id WHERE s.order_number NOT LIKE '%(cancel)%' 
        AND s.payment_type LIKE '%เครดิต%' AND s.payment_type NOT LIKE '%หมดอายุ%' 
        AND s.customer_id = '$cus_id' AND s.date_time NOT LIKE '%$date%'";
    }else{
        $query = "SELECT s.order_id,s.order_number,c.cus_name,s.total_price,s.date_time,s.payment_type 
        FROM sale_order s INNER JOIN customer c ON s.customer_id = c.cus_id WHERE s.order_number NOT LIKE '%(cancel)%' 
        AND s.payment_type LIKE '%เครดิต%' AND s.payment_type NOT LIKE '%หมดอายุ%' 
        AND s.customer_id = '$cus_id' AND s.date_time LIKE '%$date%'";
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