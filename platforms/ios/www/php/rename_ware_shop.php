<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $id  = $_POST['id'];
    $type  = $_POST['type'];
    $name = $_POST['name'];
    
    mysqli_autocommit($conn,FALSE);
    if($type == "โกดัง"){
        $sql = "UPDATE warehouse_detail SET ware_name = '$name' WHERE ware_id = '$id'";         
    }else if($type == "หน้าร้าน"){
        $sql = "UPDATE shop_detail SET shop_name = '$name' WHERE shop_id = '$id'";       
    }
    $result = mysqli_query($conn, $sql);      
        
    if($result){
        echo "success";
        mysqli_commit($conn);
    }else{
        echo "fail";
        mysqli_rollback($conn);
    }    
    mysqli_close($conn);
?>