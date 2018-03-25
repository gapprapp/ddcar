<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd"); 
    $qr = $_POST['qr'];    

    $query = "SELECT d.ware_name,p.prod_name,w.amount FROM warehouse w INNER JOIN warehouse_detail d
    ON w.ware_id = d.ware_id INNER JOIN product p ON w.prod_id = p.prod_id WHERE p.prod_code = '$qr' 
    ORDER BY  w.ware_id ASC";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){    
      while($row = mysqli_fetch_array($result)){            
            $output[] = $row;
      }   
    }

    $query = "SELECT d.shop_name,p.prod_name,s.amount FROM shop s INNER JOIN shop_detail d
    ON s.shop_id = d.shop_id INNER JOIN product p ON s.prod_id = p.prod_id WHERE p.prod_code = '$qr' 
    ORDER BY s.shop_id ASC";
    $result = mysqli_query($conn, $query);

    
    if(mysqli_num_rows($result) > 0){    
      while($row = mysqli_fetch_array($result)){            
            $output[] = $row;
      }   
    }

    if($result){
        echo json_encode($output);		   
    }else{
        echo "connection fail!";
    }
	mysqli_close($conn);
?>