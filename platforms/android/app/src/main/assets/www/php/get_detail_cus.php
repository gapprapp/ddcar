<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd"); 
    $cus_id = $_POST['cus_id'];  

    $query = "SELECT c.cus_name,c.cus_tel,c.cus_addr,c.cus_type,d.cus_price,p.prod_name 
    FROM customer c INNER JOIN detail_cus d ON c.cus_id = d.cus_id INNER JOIN product p
    ON d.prod_id = p.prod_id WHERE c.cus_id = '$cus_id'";
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