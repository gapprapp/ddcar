<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_GET['name_prod'];    
    $code  = $_GET['code'];   
    $parent  = $_GET['parent'];

    mysqli_autocommit($conn,FALSE);   
    // Convert to base64 
    $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
    $image = 'data:image/jpeg;base64,'.$image_base64;

    $sql = "INSERT INTO product(prod_name,prod_code,img) 
    VALUE ('$name','$code','".$image."')";
    $result = mysqli_query($conn, $sql);    
    $title = mysqli_insert_id($conn);	

    $sql = "SELECT lft,rgt FROM tree WHERE title = '$parent'";
    $result1 = mysqli_query($conn, $sql);  
        if(mysqli_num_rows($result1) > 0){    
            while($row = mysqli_fetch_array($result1)){            
              $rgt = $row['rgt'];
              $last_child =  $rgt-1;
              
              $sql = "UPDATE tree SET rgt = rgt + 2 WHERE rgt > '$last_child'";
              $result = mysqli_query($conn, $sql);  
              $sql = "UPDATE tree SET lft = lft + 2 WHERE lft > '$last_child'";
              $result = mysqli_query($conn, $sql);  

              $sql = "INSERT INTO tree(title,lft,rgt) VALUES ('$title','$rgt','$rgt'+1)";
              $result = mysqli_query($conn, $sql);  
            }   
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