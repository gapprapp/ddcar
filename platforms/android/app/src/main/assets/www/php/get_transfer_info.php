<?php
    include "db.php";
    $imp_id = $_POST['imp_id'];

    $query = "SELECT s.tran_number,s.shop_id,w.shop_name,s.date_time,s.total_tran,i.item_id,i.prod_id,p.prod_name,i.tran_cost,i.amount,u.user_name,
    p.prod_code,p.prod_price
    FROM transfer_in s INNER JOIN shop_detail w ON s.shop_id = w.shop_id INNER JOIN transfer_in_item i ON s.tran_id = i.tran_id 
    INNER JOIN product p ON i.prod_id = p.prod_id INNER JOIN user u ON s.user_id = u.user_id WHERE s.tran_id = '$imp_id'";
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