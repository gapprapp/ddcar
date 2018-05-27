<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $id  = $_POST['id'];
    $type  = $_POST['type'];
    $name = $_POST['name'];    

    mysqli_begin_transaction($conn); 
    //if($name){
        if($type == "โกดัง"){
            $sql = "UPDATE warehouse_detail SET ware_name = '$name' WHERE ware_id = '$id'"; 
            $result = mysqli_query($conn, $sql);   
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }     
        }else if($type == "หน้าร้าน"){
            $sql = "UPDATE shop_detail SET shop_name = '$name' WHERE shop_id = '$id'"; 
            $result = mysqli_query($conn, $sql);   
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }       
        }          
    /*}else{
        if($type == "โกดัง"){
            $sql = "INSERT INTO warehouse_detail(ware_name) VALUE ((SELECT shop_name FROM shop_detail WHERE shop_id = '$id'))"; 
            $result = mysqli_query($conn, $sql);         
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }   
            $sql = "DELETE FROM shop_detail WHERE shop_id = '$id'";   
            $result = mysqli_query($conn, $sql);   
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }               
        }else if($type == "หน้าร้าน"){
            $sql = "INSERT INTO shop_detail(shop_name) VALUE ((SELECT ware_name FROM warehouse_detail WHERE ware_id = '$id'))"; 
            $result = mysqli_query($conn, $sql);  
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }          
            $sql = "DELETE FROM warehouse_detail WHERE ware_id = '$id'"; 
            $result = mysqli_query($conn, $sql);      
            if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
            }                
        }       
    } */
    echo "success";
    mysqli_commit($conn);   
    mysqli_close($conn);
?>