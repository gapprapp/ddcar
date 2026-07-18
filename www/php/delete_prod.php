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
            
            // ลบ Node สินค้าออกจากตาราง tree (ข้อมูล parent_title ในแถวนี้จะถูกลบหายไปพร้อมกัน)
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
        
        // ลบข้อมูลสินค้าออกจากตารางหลัก product
        $sql = "DELETE FROM product WHERE prod_id = '$title'";
        $result = mysqli_query($conn, $sql); 
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }     
    }  
    
    mysqli_commit($conn); 
    echo "success";
    mysqli_close($conn);
?>