<?php
    include "db.php"; 
    $prod_id = $_POST['prod_id'];  
    $output = array(); 
   
    $query = "SELECT img FROM product WHERE prod_id = '$prod_id'";     
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