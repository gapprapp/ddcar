<?php
    include "db.php";
    $imp_id = $_POST['imp_id'];

    $query = "SELECT t.branch_id,w.ware_name,t.date_time,t.total,i.item_id,i.prod_id,p.prod_name,i.prod_price,i.prod_amount,u.user_name,
    p.prod_code,p.prod_price 
    FROM transfer_record t INNER JOIN warehouse_detail w ON t.branch_id = w.ware_id INNER JOIN transfer_record_item i ON t.tf_id = i.tf_id 
    INNER JOIN product p ON i.prod_id = p.prod_id INNER JOIN user u ON t.user = u.user_id WHERE t.tf_id = '$imp_id'";
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