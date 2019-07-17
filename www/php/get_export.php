<?php
    include "db.php";
    $start = $_POST['start'];
    $output = array();
    $txt = "(cancel)";

    if(isset($_POST['date'])){
        $date = $_POST['date'];
        $date_to = $_POST['date_to'];
        $query = "SELECT s.stock_out_id,s.stock_out_number,w.ware_name,s.date_time FROM stock_out s INNER JOIN warehouse_detail w
        ON s.ware_id = w.ware_id WHERE s.date_time BETWEEN '$date' AND '$date_to' AND s.stock_out_number NOT LIKE '%$txt%' LIMIT $start,20";
    }else if(isset($_POST['value'])){
        $val = $_POST['value'];     
        $query = "SELECT s.stock_out_id,s.stock_out_number,w.ware_name,s.date_time FROM stock_out s INNER JOIN warehouse_detail w
        ON s.ware_id = w.ware_id WHERE (s.stock_out_number LIKE '%$val%' OR w.ware_name LIKE '%$val%') 
        AND s.stock_out_number NOT LIKE '%$txt%' ORDER BY s.stock_out_id DESC LIMIT $start,20";
    }else{
        $query = "SELECT s.stock_out_id,s.stock_out_number,w.ware_name,s.date_time FROM stock_out s INNER JOIN warehouse_detail w
        ON s.ware_id = w.ware_id WHERE s.stock_out_number NOT LIKE '%$txt%' ORDER BY s.stock_out_id DESC LIMIT $start,20";
    }    
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        if(mysqli_num_rows($result) < 20){           
            $output[] = 'last';
        }else{
            $output[] = 'not last';
        }
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