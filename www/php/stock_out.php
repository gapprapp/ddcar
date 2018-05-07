<?php
    $conn = mysqli_connect("localhost", "id3340019_dd", "pkl2468GG", "id3340019_dd");    
    $input  = $_POST['JSON'];
    $obj = json_decode($input,true);  	
    $ware_id  = $_POST['ware_id'];   
    $dt  = $_POST['date'];   
    $last_id = "";
    $i = 0;

    mysqli_autocommit($conn,FALSE);
    $sql = "SELECT stock_out_number,count FROM stock_out ORDER BY stock_out_id DESC LIMIT 1"; 
    $result = mysqli_query($conn, $sql);   
  
    if(mysqli_num_rows($result) > 0){    
        while($row = mysqli_fetch_array($result)){  
            $number = $row['stock_out_number'];
            $year_old = substr($number,3,2);
            $year_cur = date("y");
            if($year_cur == $year_old){
                $count = $row['count']+1;
                $year = "EXP" . $year_cur . "-";
                $stock_number = $year . str_pad($count, 5, "0",STR_PAD_LEFT);
                $sql2 = "INSERT INTO stock_out (stock_out_number,date_time,ware_id,count) 
                VALUES ('$stock_number','$dt','$ware_id','$count')"; 
                $result2 = mysqli_query($conn, $sql2);
                $last_id = mysqli_insert_id($conn);	
                //echo "normal"; 
            }else{
                $year = "EXP" . $year_cur . "-";
                $stock_number = $year . str_pad(1, 5, "0",STR_PAD_LEFT);
                $sql3 = "INSERT INTO stock_out (stock_number,date_time,ware_id,count) 
                VALUES ('$stock_number','$dt','$ware_id',1)"; 
                $result3 = mysqli_query($conn, $sql3);
                $last_id = mysqli_insert_id($conn);	
                //echo "year dif"; 
            }           
        }
    }else{
        $year = "EXP" . date("y") . "-";
        $stock_number = $year . str_pad(1, 5, "0",STR_PAD_LEFT);
        $sql1 = "INSERT INTO stock_out (stock_number,date_time,ware_id,count) 
        VALUES ('$stock_number','$dt','$ware_id',1)"; 
        $result1 = mysqli_query($conn, $sql1);
        $last_id = mysqli_insert_id($conn);	
        //echo "empty"; 
    }   
    foreach ($obj as $data)
    {
        $i++;
        $item = $i;
        $prod_id = $data['prod_id'];
        $cost = $data['cost'];    
        $amt = $data['amt'];  

        $sql_item = "INSERT INTO stock_out_item (stock_out_id,item_id,prod_id,stock_out_cost,amount) VALUE ('$last_id','$item','$prod_id','$cost','$amt')"; 
        $result_item = mysqli_query($conn, $sql_item);       
       
        $sql_up = "UPDATE warehouse SET amount = amount-'$amt' WHERE ware_id = '$ware_id' AND prod_id = '$prod_id'"; 
        $result_up = mysqli_query($conn, $sql_up);            
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