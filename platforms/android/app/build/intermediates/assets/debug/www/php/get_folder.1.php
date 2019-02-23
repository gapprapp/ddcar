<?php
    include "db.php";
    $parent  = $_POST['parent']; 
    $msg = ""; 
    $output = array();  
   
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
                $prod_id = $row['title']; 
                $sql = "SELECT prod_name FROM product WHERE prod_id = '$prod_id'";
                $result1 = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result1) > 0){    
                    while($row1 = mysqli_fetch_array($result1)){                      
                        array_push($row,$row1);
                    }                    
                }
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