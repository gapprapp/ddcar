<?php
    include "db.php";
    
    // 1. รับค่าและตัดเว้นวรรค + ป้องกัน SQL Injection
    $parent = isset($_POST['parent']) ? trim(mysqli_real_escape_string($conn, $_POST['parent'])) : 'car'; 

    $msg = ""; 
    $output = array();  
   
    // 2. Query ดึงข้อมูลโดยตรงจาก parent_title (เทียบ string กันโดยตรงด้วย CAST)
    $sql = "SELECT 
                node.title,
                p.prod_name,
                p.prod_code,
                p.prod_id
            FROM tree AS node
            LEFT JOIN product AS p ON node.title = CAST(p.prod_id AS CHAR)
            WHERE node.parent_title = '$parent'
            ORDER BY node.title ASC;"; 

    $result = mysqli_query($conn, $sql); 
  
    if($result && mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            // ถ้าเป็นสินค้า (มี prod_id)
            if(!empty($row['prod_id'])){
                $msg = "last node";
                $output[] = [
                    'prod_name' => $row['prod_name'],
                    'prod_code' => $row['prod_code'],
                    'prod_id'   => $row['prod_id']
                ];
            } else {
                // ถ้าเป็นโฟลเดอร์ย่อย
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