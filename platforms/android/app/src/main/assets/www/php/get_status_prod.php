<?php
    include "db.php";
    $start = $_POST['start'];
    $output = array();     

    $query = "SELECT prod_name,prod_id,status FROM product WHERE status != 'normal' ORDER BY status ASC LIMIT $start,20";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){    
      while($row = mysqli_fetch_array($result)){ 
        $prod_id = $row['prod_id'];
        $amount = 0;   
        $sql = "SELECT amount FROM warehouse WHERE prod_id = '$prod_id'"; 
        $result1 = mysqli_query($conn, $sql); 
        if(mysqli_num_rows($result1) > 0){    
            while($row1 = mysqli_fetch_array($result1)){  
                $amount += $row1['amount'];                    
            }
        } 
        $sql = "SELECT amount FROM shop WHERE prod_id = '$prod_id'"; 
        $result2 = mysqli_query($conn, $sql); 
        if(mysqli_num_rows($result2) > 0){    
            while($row2 = mysqli_fetch_array($result2)){  
                $amount += $row2['amount'];                    
            }
        }
        array_push($row,$amount);   
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