<?php
    include "db.php";
    $output = array();
    $date = $_POST['date'];
    $date_from = $date.' 00:00:00';
    $date_to = $date.' 23:59:59';
    $txt = "(cancel)";
    
    $query = "SELECT s.order_id,s.order_number,u.user_name,s.total_price FROM sale_order s INNER JOIN user u
    ON s.user_id = u.user_id WHERE s.date_time BETWEEN '$date_from' AND '$date_to' AND s.order_number NOT LIKE '%$txt%'";    
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