<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $name  = $_POST['name_prod'];    
    $code  = $_POST['code'];   
    $parent  = $_POST['parent'];

    mysqli_begin_transaction($conn);
    $sql = "INSERT INTO product(prod_name,prod_code) VALUE ('$name','$code')";
    $result = mysqli_query($conn, $sql);    
    $title = mysqli_insert_id($conn);
    if(!$result){
        mysqli_rollback($conn);
        echo "fail";
        exit;
    } 	

    $sql = "SELECT lft,rgt FROM tree WHERE title = '$parent'";
    $result1 = mysqli_query($conn, $sql);  
        if(mysqli_num_rows($result1) > 0){    
            while($row = mysqli_fetch_array($result1)){            
              $rgt = $row['rgt'];
              $last_child =  $rgt-1;
              
              $sql = "UPDATE tree SET rgt = rgt + 2 WHERE rgt > '$last_child'";
              $result = mysqli_query($conn, $sql);  
              if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
              } 
              $sql = "UPDATE tree SET lft = lft + 2 WHERE lft > '$last_child'";
              $result = mysqli_query($conn, $sql);  
              if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
              } 
              $sql = "INSERT INTO tree(title,lft,rgt) VALUES ('$title','$rgt','$rgt'+1)";
              $result = mysqli_query($conn, $sql); 
              if(!$result){
                mysqli_rollback($conn);
                echo "fail";
                exit;
              }  
            }   
        }       
    mysqli_commit($conn); 
    echo "success";   
    mysqli_close($conn);
?>