<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");    
    $input  = $_POST['JSON'];
    $obj = json_decode($input,true);  	
    $ware_id  = $_POST['ware_id'];   
    $dt  = $_POST['date']; 

    mysqli_autocommit($conn,FALSE); 
    $sql = "INSERT INTO stock_in (date_time) VALUE ('$dt')"; 
    $result = mysqli_query($conn, $sql); 
    $last_id = mysqli_insert_id($conn);	
   
    foreach ($obj as $data)
    {
        $item = $data['item_id'];
        $prod_id = $data['prod_id'];
        $cost = $data['cost'];    
        $amt = $data['amt'];  

        $sql_item = "INSERT INTO stock_in_item (stock_id,item_id,prod_id,ware_id,stock_cost,amount) VALUE ('$last_id','$item','$prod_id','$ware_id','$cost','$amt')"; 
        $result_item = mysqli_query($conn, $sql_item);
        
        $query = "SELECT prod_id FROM warehouse WHERE ware_id = '$ware_id' AND prod_id = '$prod_id'";
        $result_q = mysqli_query($conn, $query);
        if(mysqli_num_rows($result_q) > 0){ 
            $sql_up = "UPDATE warehouse SET amount = amount+'$amt' WHERE ware_id = '$ware_id' AND prod_id = '$prod_id'"; 
            $result_up = mysqli_query($conn, $sql_up);
        }else{
            $sql_in = "INSERT INTO warehouse (ware_id,prod_id,amount) VALUE ('$ware_id','$prod_id','$amt')"; 
            $result_in = mysqli_query($conn, $sql_in);
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