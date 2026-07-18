<?php  
    include "db.php";
    
    // 1. เพิ่มความปลอดภัยป้องกัน SQL Injection
    $title  = mysqli_real_escape_string($conn, $_POST['title']);

    mysqli_begin_transaction($conn);
    
    $sql = "SELECT lft,rgt FROM tree WHERE title = '$title'";
    $result1 = mysqli_query($conn, $sql);  
    if(mysqli_num_rows($result1) > 0){    
        while($row = mysqli_fetch_array($result1)){ 
            $lft = $row['lft']; 
            $rgt = $row['rgt'];   
            $width = $rgt - $lft + 1;       
            
            // ลบ Node ตัวเองและลูกๆ ทั้งหมดภายใต้ขอบเขต (คอลัมน์ parent_title จะหายไปพร้อมแถวที่โดนลบ)
            $sql = "DELETE FROM tree WHERE lft BETWEEN '$lft' AND '$rgt'";
            $result = mysqli_query($conn, $sql);
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }    
          
            $sql = "UPDATE tree SET rgt = rgt - $width WHERE rgt > '$rgt'";
            $result = mysqli_query($conn, $sql);  
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }  
            
            $sql = "UPDATE tree SET lft = lft - $width WHERE lft > '$rgt'";
            $result = mysqli_query($conn, $sql);
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }
        }
    }
        
    // 2. ⭐ จุดที่ปรับปรุงใหญ่: เปลี่ยนจาก while loop มาเป็นการลบสินค้ากำพร้าในคำสั่งเดียว
    // ปรับเงื่อนไขการเชื่อมตารางให้ตรงกัน (ไม่ใช้ CAST ในการเทียบตอนลบเพื่อให้เร็วขึ้น)
    $sql_clean_products = "DELETE FROM product 
                           WHERE prod_id NOT IN (
                               SELECT title FROM tree WHERE title IS NOT NULL
                           )";
    
    $result_clean = mysqli_query($conn, $sql_clean_products);
    if(!$result_clean){
        mysqli_rollback($conn);
        echo "fail";
        exit;
    }

    mysqli_commit($conn); 
    echo "success"; 
    mysqli_close($conn);
?>