<?php
    include "db.php";
    $data = $_POST['phrase'];
    $output = array();
      
    $query = "SELECT * FROM product WHERE prod_name LIKE '%$data%' OR prod_code LIKE '%$data%' ORDER BY prod_code ASC";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            $prod_id = $row['prod_id'];            
            if(isset($_GET['ware_id'])){
                $ware_id = $_GET['ware_id'];
                $type = $_GET['type'];
                if($type == "หน้าร้าน"){
                    $query = "SELECT amount FROM shop WHERE prod_id = '$prod_id' AND shop_id = '$ware_id'";
                    $result1 = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result1) > 0){    
                        while($row1 = mysqli_fetch_array($result1)){      
                            $row['min_amount'] = $row1['amount'];
                        }   
                    }else{
                        $row['min_amount'] = 0;
                    }
                }else if($type == "โกดัง"){
                    $query = "SELECT amount FROM warehouse WHERE prod_id = '$prod_id' AND ware_id = '$ware_id'";
                    $result1 = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result1) > 0){    
                        while($row1 = mysqli_fetch_array($result1)){      
                            $row['min_amount'] = $row1['amount'];
                        }   
                    }else{
                        $row['min_amount'] = 0;
                    }
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