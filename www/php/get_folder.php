<?php
    include "db.php";
    // แนะนำ: ควรกรองข้อมูลเพื่อป้องกัน SQL Injection เช่น mysqli_real_escape_string($conn, $_POST['parent'])
    $parent = mysqli_real_escape_string($conn, $_POST['parent']); 

    // 1. ตั้งชื่อไฟล์แคชตามโฟลเดอร์ที่เรียก
    $cache_file = "cache_" . md5($parent) . ".json";
    $cache_time = 300; // กำหนดให้อายุแคชอยู่ได้ 5 นาที (300 วินาที) แล้วค่อยคิวรีใหม่

    // 2. ตรวจสอบว่ามีไฟล์แคชเดิมอยู่ไหม และยังไม่หมดอายุใช่หรือไม่?
    if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
        // ถ้ามีและยังไม่หมดอายุ ให้ส่งข้อมูลจากแคชออกไปทันที (เร็วระดับ 0.001 วินาที)
        echo file_get_contents($cache_file);
        exit;
    }

    // 3. ถ้าไม่มีแคช หรือแคชหมดอายุ ค่อยรัน Query หลักของระบบ Nested Set ข้างล่างนี้
    $msg = ""; 
    $output = array();  
   
    // ใช้ SQL ที่รวม LEFT JOIN แล้วจากข้อ 1
        $sql = "SELECT 
                node.title,
                p.prod_name,
                p.prod_code,
                p.prod_id
            FROM tree AS node
            LEFT JOIN product AS p ON node.title = p.prod_id -- แนะนำให้เชื่อมด้วย ID ตรงๆ ไม่เอา CAST
            WHERE node.parent_title = '$parent'
            ORDER BY node.lft;" ; 

    $result = mysqli_query($conn, $sql); 
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            // ถ้ามีข้อมูลสินค้า (แสดงว่าเป็น Node สินค้า)
            if(!empty($row['prod_id'])){
                $msg = "last node";
                $output[] = [
                    'prod_name' => $row['prod_name'],
                    'prod_code' => $row['prod_code'],
                    'prod_id' => $row['prod_id']
                ];
            } else {
                // ถ้าไม่มีข้อมูลสินค้า แสดงว่าเป็นโฟลเดอร์ย่อย
                $output[] = [
                    'title' => $row['title'],
                    'depth' => $row['depth']
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