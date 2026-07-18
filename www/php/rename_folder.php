<?php
    include "db.php";
    
    // 1. ดักความปลอดภัยป้องกัน SQL Injection
    $name      = mysqli_real_escape_string($conn, $_POST['name']);   
    $old_name  = mysqli_real_escape_string($conn, $_POST['old_name']);

    // เริ่มต้น Transaction เพื่อให้มั่นใจว่าต้องอัปเดตสำเร็จทั้งสองคิวรี
    mysqli_begin_transaction($conn);

    // คิวรีที่ 1: เปลี่ยนชื่อตัวมันเอง (โค้ดเดิมของคุณ)
    $sql1 = "UPDATE tree SET title = '$name' WHERE title = '$old_name'";
    $result1 = mysqli_query($conn, $sql1);
            
    if(!$result1){
        mysqli_rollback($conn);
        echo "fail";      
        exit;
    }

    // ⭐ คิวรีที่ 2: จุดที่ต้องเพิ่มเข้ามาเพื่ออัปเดตชื่อพ่อให้กับลูกๆ สายตรงทั้งหมด
    $sql2 = "UPDATE tree SET parent_title = '$name' WHERE parent_title = '$old_name'";
    $result2 = mysqli_query($conn, $sql2);

    if(!$result2){
        mysqli_rollback($conn);
        echo "fail";      
        exit;
    }

    // ทำงานสำเร็จทั้งหมดจึงทำการ Commit ข้อมูล
    mysqli_commit($conn);
    echo "success";      
    mysqli_close($conn);
?>