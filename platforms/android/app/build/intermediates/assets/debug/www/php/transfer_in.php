<?php 
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");    
    $input  = $_POST['JSON'];
    $obj = json_decode($input,true);  	
    $shop_id  = $_POST['shop_id'];   
    $dt  = $_POST['date']; 
    $i = 0;  

    mysqli_autocommit($conn,FALSE); 
    $sql = "INSERT INTO transfer_in (date_time,shop_id) VALUE ('$dt','$shop_id')"; 
    $result = mysqli_query($conn, $sql); 
    $last_id = mysqli_insert_id($conn);	
   
    foreach ($obj as $data)
    {
        $i++;
        $item = $i;
        $prod_id = $data['prod_id'];         
        $amt = $data['amt']; 
        $addr = $data['addr']; 

        $sql_item = "INSERT INTO transfer_in_item (tran_id,item_id,prod_id,amount) VALUE ('$last_id','$item','$prod_id','$amt')"; 
        $result_item = mysqli_query($conn, $sql_item);
        
        $query = "SELECT prod_id FROM shop WHERE shop_id = '$shop_id' AND prod_id = '$prod_id'";
        $result_q = mysqli_query($conn, $query);
        if(mysqli_num_rows($result_q) > 0){ 
            $sql_up = "UPDATE shop SET amount = amount+'$amt',place = CONCAT(place,'" .$addr."') WHERE shop_id = '$shop_id' AND prod_id = '$prod_id'"; 
            $result_up = mysqli_query($conn, $sql_up);
        }else{
            $sql_in = "INSERT INTO shop (shop_id,prod_id,amount,place) VALUE ('$shop_id','$prod_id','$amt','$addr')"; 
            $result_in = mysqli_query($conn, $sql_in);
        }
        $sql = "INSERT INTO shop_place (shop_id,prod_id,place) VALUE ('$shop_id','$prod_id','$addr')"; 
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