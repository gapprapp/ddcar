<?php  
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");  
    $title  = $_POST['title'];

    mysqli_autocommit($conn,FALSE);
    $sql = "SELECT lft,rgt FROM tree WHERE title = '$title'";
    $result1 = mysqli_query($conn, $sql);  
        if(mysqli_num_rows($result1) > 0){    
            while($row = mysqli_fetch_array($result1)){ 
                $lft = $row['lft']; 
                $rgt = $row['rgt'];   
                $width = $rgt - $lft + 1;       
                $sql = "DELETE FROM tree WHERE lft BETWEEN '$lft' AND '$rgt'";
                $result = mysqli_query($conn, $sql);  
              
                $sql = "UPDATE tree SET rgt = rgt - $width WHERE rgt > '$rgt'";
                $result = mysqli_query($conn, $sql);  
                $sql = "UPDATE tree SET lft = lft - $width WHERE lft > '$rgt'";
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