<?php
    include "db.php";
    
    // 1. ป้องกัน SQL Injection ด้วย mysqli_real_escape_string
    $parent   = mysqli_real_escape_string($conn, $_POST['parent']);
    $order_by = (strtoupper($_POST['order_by']) === 'DESC') ? 'DESC' : 'ASC'; // ตรวจสอบความปลอดภัยคีย์เวิร์ด ORDER BY
    
    $msg = ""; 
    $output = array();  
   
    // 3. ใช้ Query ใหม่ ดึงข้อมูลจบในรอบเดียว (LEFT JOIN ตารางสินค้าตั้งแต่แรก)
    // โดยใช้เงื่อนไขคัดกรองจาก parent_title ตรงๆ ไม่พึ่งพาสูตรคำนวณคณิตศาสตร์ Nested Set ให้ช้า
    $sql = "SELECT 
                node.title,
                p.prod_name,
                p.prod_code,
                p.img,
                p.prod_id
            FROM tree AS node
            -- แทนที่จะใช้ CAST ที่ฝั่ง product ให้เปลี่ยนมา JOIN แบบนี้แทนครับ:
            LEFT JOIN product AS p ON p.prod_id = node.title 
            WHERE node.parent_title = '$parent'
            ORDER BY node.title $order_by;";

    $result = mysqli_query($conn, $sql); 
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            // ตรวจสอบว่ามีข้อมูลสินค้าติดมาด้วยหรือไม่ (ใช้เช็กแทน IS_NUMERIC ได้แม่นยำกว่า)
            if(!empty($row['prod_id'])){
                $msg = "last node";
                $output[] = [
                    'prod_name' => $row['prod_name'],
                    'prod_code' => $row['prod_code'],
                    'img'       => $row['img'],
                    'prod_id'   => $row['prod_id']
                ];
            } else {
                // ถ้าไม่มีข้อมูลสินค้า แสดงว่าเป็นโฟลเดอร์ย่อย
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