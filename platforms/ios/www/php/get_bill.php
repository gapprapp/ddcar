<?php
    include "db.php";
    $output = array();
    $txt = "(cancel)";

    if(isset($_POST['date'])){
        $date = $_POST['date'];
        $date_to = $_POST['date_to'];
        $query = "SELECT s.order_id,s.order_number,c.cus_name,s.date_time FROM sale_order s INNER JOIN customer c
        ON s.customer_id = c.cus_id WHERE date_time BETWEEN '$date' AND '$date_to' AND s.order_number NOT LIKE '%$txt%'";
    }else{
        $query = "SELECT s.order_id,s.order_number,c.cus_name,s.date_time FROM sale_order s INNER JOIN customer c
        ON s.customer_id = c.cus_id WHERE s.order_number NOT LIKE '%$txt%' ORDER BY s.order_id DESC";
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