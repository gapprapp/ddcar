<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");
    $title  = $_POST['title'];    
    $parent  = $_POST['parent'];
   
    $sql = "SELECT title FROM tree";
    $result = mysqli_query($conn, $sql);  

    mysqli_autocommit($conn,FALSE);   
    if(mysqli_num_rows($result) == 0){    
        $sql = "INSERT INTO tree(title,lft,rgt) VALUES ('car','1','2')";
        $result = mysqli_query($conn, $sql);          
    }

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