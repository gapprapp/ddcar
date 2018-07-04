<?php
    include "db.php";
    $output = array();
    $txt = "(cancel)";

    if(isset($_POST['date'])){
        $date = $_POST['date'];
        $date_to = $_POST['date_to'];
        $query = "SELECT s.stock_id,s.stock_number,w.ware_name,s.date_time FROM stock_in s INNER JOIN warehouse_detail w
        ON s.ware_id = w.ware_id WHERE s.date_time BETWEEN '$date' AND '$date_to' AND s.stock_number NOT LIKE '%$txt%'";
    }else{
        $query = "SELECT s.stock_id,s.stock_number,w.ware_name,s.date_time FROM stock_in s INNER JOIN warehouse_detail w
        ON s.ware_id = w.ware_id WHERE s.stock_number NOT LIKE '%$txt%' ORDER BY s.stock_id DESC";
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