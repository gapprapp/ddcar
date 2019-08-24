<?php
    include "db.php";
    $start = $_POST['start'];
    $output = array();
    $txt = "(cancel)";

    if(isset($_POST['date'])){
        $date = $_POST['date'];
        $date_to = $_POST['date_to'];
        $query = "SELECT s.tran_id,s.tran_number,w.shop_name,s.date_time FROM transfer_in s INNER JOIN shop_detail w
        ON s.shop_id = w.shop_id WHERE s.date_time BETWEEN '$date' AND '$date_to' AND s.tran_number NOT LIKE '%$txt%' LIMIT $start,20";
    }else if(isset($_POST['value'])){
        $val = $_POST['value'];     
        $query = "SELECT DISTINCT s.tran_id,s.tran_number,w.shop_name,s.date_time FROM transfer_in s INNER JOIN shop_detail w
        ON s.shop_id = w.shop_id INNER JOIN transfer_in_item i ON s.tran_id = i.tran_id INNER JOIN product p
        ON i.prod_id = p.prod_id WHERE (s.tran_number LIKE '%$val%' OR w.shop_name LIKE '%$val%' OR p.prod_name LIKE '%$val%') 
        AND s.tran_number NOT LIKE '%$txt%' ORDER BY s.tran_id DESC LIMIT $start,20";
    }else{
        $query = "SELECT s.tran_id,s.tran_number,w.shop_name,s.date_time FROM transfer_in s INNER JOIN shop_detail w
        ON s.shop_id = w.shop_id WHERE s.tran_number NOT LIKE '%$txt%' ORDER BY s.tran_id DESC LIMIT $start,20";
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