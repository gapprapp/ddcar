<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd"); 
    $cus_id = $_POST['cus_id'];

    if(isset($_POST['qr'])){
        $qr = $_POST['qr'];    
        $query = "SELECT * FROM product WHERE prod_code = '$qr'";
    }else if(isset($_POST['prod_id'])){
        $prod_id = $_POST['prod_id']; 
        $query = "SELECT * FROM product WHERE prod_id = '$prod_id'";
    }    
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){    
      while($row = mysqli_fetch_array($result)){ 
        $prod_id = $row['prod_id']; 
        $query = "SELECT cus_price FROM detail_cus WHERE prod_id = '$prod_id' AND cus_id = '$cus_id'"; 
        $result1 = mysqli_query($conn, $query);   
        if(mysqli_num_rows($result1) > 0){    
            while($row1 = mysqli_fetch_array($result1)){ 
                $cus_price = $row1['cus_price'];
                array_push($row,$cus_price);              
            }   
          } 
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