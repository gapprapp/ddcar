<?php
    include "db.php";
    $start = $_POST['start'];
    $output = array();
    $txt = "(cancel)";

    if(isset($_POST['date'])){
        $date = $_POST['date'];
        $date_to = $_POST['date_to'];
        $query = "SELECT t.tf_id,w.ware_name,t.date_time FROM transfer_record t INNER JOIN warehouse_detail w
        ON t.branch_id = w.ware_id WHERE t.date_time BETWEEN '$date' AND '$date_to' AND t.total NOT LIKE '%$txt%' LIMIT $start,30";
    }else if(isset($_POST['value'])){
        $val = $_POST['value'];     
        $query = "SELECT DISTINCT t.tf_id,w.ware_name,t.date_time FROM transfer_record t INNER JOIN warehouse_detail w
        ON t.branch_id = w.ware_id INNER JOIN transfer_record_item i ON t.tf_id = i.tf_id INNER JOIN product p 
        ON i.prod_id = p.prod_id WHERE (w.ware_name LIKE '%$val%' OR p.prod_name LIKE '%$val%') 
        AND t.total NOT LIKE '%$txt%' ORDER BY t.tf_id DESC LIMIT $start,30";
    }else{
        $query = "SELECT t.tf_id,w.ware_name,t.date_time FROM transfer_record t INNER JOIN warehouse_detail w
        ON t.branch_id = w.ware_id WHERE t.total NOT LIKE '%$txt%' ORDER BY t.tf_id DESC LIMIT $start,30";
    }    
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        if(mysqli_num_rows($result) < 30){           
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