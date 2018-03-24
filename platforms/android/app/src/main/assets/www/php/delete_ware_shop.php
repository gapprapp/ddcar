<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $id  = $_POST['id'];
    $type  = $_POST['type'];
    
    mysqli_autocommit($conn,FALSE);
    if($type == "โกดัง"){
        $sql = "DELETE FROM warehouse_detail WHERE ware_id = '$id'";
        $result = mysqli_query($conn, $sql);      
        $sql = "DELETE FROM warehouse WHERE ware_id = '$id'";
        $result = mysqli_query($conn, $sql);      
    }else if($type == "หน้าร้าน"){
        $sql = "DELETE FROM shop_detail WHERE shop_id = '$id'";
        $result = mysqli_query($conn, $sql);      
        $sql = "DELETE FROM shop WHERE shop_id = '$id'";
        $result = mysqli_query($conn, $sql);  
    }      
        
    if($result){
        echo "success";
        mysqli_commit($conn);
    }else{
        echo "fail";
        mysqli_rollback($conn);
    }    
    mysqli_close($conn);
?>