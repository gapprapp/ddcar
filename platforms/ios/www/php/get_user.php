<?php
    include "db.php";
    $output = array();    

    $query = "SELECT user_id,user_name,pass,phone,user_role FROM user ORDER BY user_id ASC";
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