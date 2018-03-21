<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");   
    $parent  = $_POST['parent']; 
    $msg = "";   
   
    $sql = "SELECT node.title, (COUNT(parent.title) - (sub_tree.depth + 1)) AS depth
    FROM tree AS node,
            tree AS parent,
            tree AS sub_parent,
            (
                SELECT node.title, (COUNT(parent.title) - 1) AS depth
                FROM tree AS node,
                        tree AS parent
                WHERE node.lft BETWEEN parent.lft AND parent.rgt
                        AND node.title = '$parent'
                GROUP BY node.title
                ORDER BY node.lft
            )AS sub_tree
    WHERE node.lft BETWEEN parent.lft AND parent.rgt
            AND node.lft BETWEEN sub_parent.lft AND sub_parent.rgt
            AND sub_parent.title = sub_tree.title
    GROUP BY node.title
    HAVING depth = 1
    ORDER BY node.lft;";
    $result = mysqli_query($conn, $sql); 
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){
            if(is_numeric($row['title'])){
                $msg = "last node";               
            }
            $output[] = $row;             
        }
        array_push($output,$msg);
        echo json_encode($output);   
    }else{
        echo "last node";
    } 
    mysqli_close($conn);
?>