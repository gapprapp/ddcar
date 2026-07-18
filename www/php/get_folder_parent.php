<?php
    include "db.php";
    
    // ป้องกัน SQL Injection
    $parent = mysqli_real_escape_string($conn, $_POST['parent']); 
    $msg = ""; 
    $output = array();  
   
    // ใช้ parent_id ค้นหาตรงๆ และ LEFT JOIN ตาราง product
    $sql = "SELECT 
                node.title, 
                p.prod_name, 
                p.prod_code, 
                p.prod_id
            FROM tree AS node
            LEFT JOIN product AS p ON node.title = CAST(p.prod_id AS CHAR)
            WHERE node.parent_id = '$parent'
            ORDER BY node.title;";
            
    $result = mysqli_query($conn, $sql); 
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            if(!empty($row['prod_id'])){
                $msg = "last node";
                $output[] = [
                    'prod_name' => $row['prod_name'],
                    'prod_code' => $row['prod_code'],
                    'prod_id'   => $row['prod_id']
                ];
            } else {
                $output[] = [
                    'title' => $row['title']
                ];
            }               
        }
        if($msg !== "") {
            array_push($output, $msg);
        }
        echo json_encode($output);   
    }else{
        echo "last node";
    } 
    mysqli_close($conn);
?>
<?php
    include "db.php";
    
    $parent = mysqli_real_escape_string($conn, $_POST['parent']);
    $order_by = (strtoupper($_POST['order_by']) === 'DESC') ? 'DESC' : 'ASC';
    
    $msg = ""; 
    $output = array();  
   
    // SQL จะเหลือสั้นแค่นี้ ไม่ต้องใช้ BETWEEN หรือ COUNT ให้หนักเครื่องอีกต่อไป
    $sql = "SELECT 
                node.title, 
                p.prod_name, 
                p.prod_code, 
                p.img, 
                p.prod_id
            FROM tree AS node
            LEFT JOIN product AS p ON node.title = CAST(p.prod_id AS CHAR)
            WHERE node.parent_id = '$parent' -- ค้นหาจาก parent_id ตรงๆ
            ORDER BY node.title $order_by;";

    $result = mysqli_query($conn, $sql); 
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            if(!empty($row['prod_id'])){
                $msg = "last node";
                $output[] = [
                    'prod_name' => $row['prod_name'],
                    'prod_code' => $row['prod_code'],
                    'img'       => $row['img'],
                    'prod_id'   => $row['prod_id']
                ];
            } else {
                $output[] = [
                    'title' => $row['title']
                ];
            }               
        }
        if($msg !== "") { array_push($output, $msg); }
        echo json_encode($output);   
    }else{
        echo "last node";
    } 
    mysqli_close($conn);
?>