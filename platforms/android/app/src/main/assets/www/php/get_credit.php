<?php
    include "db.php";
    $output = array();   
    $dt = date('Y-m-d');
    $lastday = date("Y-m-t", strtotime($dt));
    $firstday = date("Y-m-01", strtotime($dt)); 
   
    if(isset($_POST['value'])){
      $val = $_POST['value'];     
      $query = "SELECT d.credit_id,d.cus_id,c.cus_name,d.credit_price,d.date_time FROM credit d INNER JOIN customer c
      ON d.cus_id = c.cus_id WHERE c.cus_name LIKE '%$val%' OR d.date_time LIKE '%$val%'";
    }else{
      $query = "SELECT d.credit_id,d.cus_id,c.cus_name,d.credit_price,d.date_time FROM credit d INNER JOIN customer c
      ON d.cus_id = c.cus_id WHERE date_time BETWEEN '$firstday' AND '$lastday'";     
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