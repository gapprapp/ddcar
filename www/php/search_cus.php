<?php
    include "db.php";
    $data = $_POST['phrase'];   
    $output = array();
      
    $query = "SELECT * FROM customer WHERE cus_name LIKE '%$data%'";
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