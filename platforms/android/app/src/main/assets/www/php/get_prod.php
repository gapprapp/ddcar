<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $qr = $_POST['qr'];    
    $prod_id = $_POST['prod_id']; 

    if(isset($qr)){
        $query = "SELECT prod_id,prod_name,prod_code,prod_price,prod_pricesend,prod_cost 
        FROM product WHERE prod_code = '$qr'";
    }else if(isset($prod_id)){
        $query = "SELECT prod_id,prod_name,prod_code,prod_price,prod_pricesend,prod_cost 
        FROM product WHERE prod_id = '$prod_id'";
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
        echo "connection fail!";
    }
	mysqli_close($conn);
?>