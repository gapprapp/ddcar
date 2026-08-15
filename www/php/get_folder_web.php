<?php
    include "db.php";
    
    // 1. รับค่าและตัดเว้นวรรค
    $parent   = isset($_POST['parent']) ? trim(mysqli_real_escape_string($conn, $_POST['parent'])) : 'car';
    $order_input = isset($_POST['order_by']) ? $_POST['order_by'] : 'ASC';
    $order_by    = (strtoupper($order_input) === 'DESC') ? 'DESC' : 'ASC';
    
    $msg = ""; 
    $output = array();  
   
    // 2. Query ประสิทธิภาพสูง:
    // - เชื่อม p.prod_id = node.title ตรงๆ (MySQL จะใช้ Index จาก prod_id ได้ทันที ไม่โดน CAST บล็อก)
    // - ORDER BY node.lft (ช่วยให้เรียงตามลำดับโฟลเดอร์เดิมและรวดเร็วเพราะ lft มี Index)
    $sql = "SELECT 
                node.title,
                p.prod_name,
                p.prod_code,
                p.img,
                p.prod_id
            FROM tree AS node
            LEFT JOIN product AS p ON p.prod_id = node.title 
            WHERE node.parent_title = '$parent'
            ORDER BY node.lft $order_by;";

    $result = mysqli_query($conn, $sql); 
  
    if($result && mysqli_num_rows($result) > 0){    
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
        
        if($msg !== "") {
            array_push($output, $msg);
        }
        
        echo json_encode($output);   
    }else{
        echo "last node";
    } 
    
    mysqli_close($conn);
?>