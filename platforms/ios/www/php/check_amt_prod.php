<?php
    include "db.php";
    $output = array();

    if(isset($_POST['qr'])){
        $qr = $_POST['qr']; 
        $query = "SELECT d.ware_name,p.prod_name,w.amount,p.img,w.ware_id as id,p.prod_id FROM warehouse w INNER JOIN warehouse_detail d
        ON w.ware_id = d.ware_id INNER JOIN product p ON w.prod_id = p.prod_id WHERE p.prod_code = '$qr' 
        ORDER BY  w.ware_id ASC";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0){    
          while($row = mysqli_fetch_array($result)){ 
                array_push($row,"ware");          
                $output[] = $row;
          }   
        }
    
        $query = "SELECT d.shop_name,p.prod_name,s.amount,p.img,s.shop_id as id,p.prod_id FROM shop s INNER JOIN shop_detail d
        ON s.shop_id = d.shop_id INNER JOIN product p ON s.prod_id = p.prod_id WHERE p.prod_code = '$qr' 
        ORDER BY s.shop_id ASC";
        $result = mysqli_query($conn, $query);
    
        
        if(mysqli_num_rows($result) > 0){    
          while($row = mysqli_fetch_array($result)){ 
                array_push($row,"shop");           
                $output[] = $row;
          }   
        }
    }else if(isset($_POST['prod_id'])){
        $prod_id = $_POST['prod_id'];
        $query = "SELECT d.ware_name,p.prod_name,w.amount,p.img,w.ware_id as id FROM warehouse w INNER JOIN warehouse_detail d
        ON w.ware_id = d.ware_id INNER JOIN product p ON w.prod_id = p.prod_id WHERE p.prod_id = '$prod_id' 
        ORDER BY  w.ware_id ASC";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0){    
          while($row = mysqli_fetch_array($result)){  
                array_push($row,"ware");          
                $output[] = $row;
          }   
        }
    
        $query = "SELECT d.shop_name,p.prod_name,s.amount,p.img,s.shop_id as id FROM shop s INNER JOIN shop_detail d
        ON s.shop_id = d.shop_id INNER JOIN product p ON s.prod_id = p.prod_id WHERE p.prod_id = '$prod_id' 
        ORDER BY s.shop_id ASC";
        $result = mysqli_query($conn, $query);
    
        
        if(mysqli_num_rows($result) > 0){    
          while($row = mysqli_fetch_array($result)){
                array_push($row,"shop");            
                $output[] = $row;
          }   
        }
    }
    if($result){
        echo json_encode($output);		   
    }else{
        echo "fail";
    }
	mysqli_close($conn);
?>