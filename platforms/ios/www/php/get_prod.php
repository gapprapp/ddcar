<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd"); 

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