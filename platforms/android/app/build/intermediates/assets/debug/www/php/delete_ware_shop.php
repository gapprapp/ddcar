<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $id  = $_POST['id'];
    $type  = $_POST['type'];
    
    mysqli_begin_transaction($conn);
    if($type == "โกดัง"){
        $sql = "DELETE FROM warehouse_detail WHERE ware_id = '$id'";
        $result = mysqli_query($conn, $sql);   
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }     
        $sql = "DELETE FROM warehouse WHERE ware_id = '$id'";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }        
    }else if($type == "หน้าร้าน"){
        $sql = "DELETE FROM shop_detail WHERE shop_id = '$id'";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            mysqli_rollback($conn);
            echo "fail";
            exit;
        }        
        $sql = "DELETE FROM shop WHERE shop_id = '$id'";
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