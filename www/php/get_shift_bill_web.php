<?php
    include "db.php";
    $output = array();
    $date_f = $_POST['datefrom'];
    $date_t = $_POST['dateto'];
    $date_from = $date_f.' 00:00:00';
    $date_to = $date_t.' 23:59:59';
    $txt = "(cancel)";    

    $query = "SELECT s.order_id,s.order_number,u.user_name,s.total_price,s.count FROM sale_order s INNER JOIN user u
    ON s.user_id = u.user_id WHERE s.date_time BETWEEN '$date_from' AND '$date_to' AND s.order_number NOT LIKE '%$txt%'";    
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){    
      while($row = mysqli_fetch_array($result)){
        $order_id = $row['order_id'];
        $query1 = "SELECT prod_id,prod_amount FROM sale_order_item WHERE order_id = '$order_id'";    
        $result1 = mysqli_query($conn, $query1);
        $cost = 0;
        if(mysqli_num_rows($result1) > 0){    
          while($row1 = mysqli_fetch_array($result1)){
            $prod_id = $row1['prod_id'];
            $prod_amt = $row1['prod_amount'];
            $query2 = "SELECT prod_cost FROM product WHERE prod_id = '$prod_id'";    
            $result2 = mysqli_query($conn, $query2);
            if(mysqli_num_rows($result2) > 0){    
              while($row2 = mysqli_fetch_array($result2)){                
                $cost = $cost + ($row2['prod_cost']*$prod_amt);               
              }   
            }  
          }   
        }
        $row['count'] = $cost;
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