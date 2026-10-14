<?php
    include "db.php";
    include_once "folder_helper.php";

    $data = isset($_POST['phrase']) ? trim(mysqli_real_escape_string($conn, $_POST['phrase'])) : '';
    $output = array();

    if ($data === '') {
        echo json_encode($output);
        mysqli_close($conn);
        exit;
    }
      
    $query = "SELECT * FROM product WHERE prod_name LIKE '%$data%' OR prod_code LIKE '%$data%' ORDER BY prod_code ASC";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0){
        $raw_rows = array();
        $prod_ids = array();
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $raw_rows[] = $row;
            $prod_ids[] = $row['prod_id'];
        }

        // Batch ดึงโครงสร้างโฟลเดอร์ของสินค้าทั้งหมดใน 1 คิวรี
        $folder_map = get_products_folder_paths($conn, $prod_ids);

        foreach($raw_rows as $row){
            $prod_id = $row['prod_id'];            
            if(isset($_GET['ware_id'])){
                $ware_id = mysqli_real_escape_string($conn, $_GET['ware_id']);
                $type = isset($_GET['type']) ? $_GET['type'] : '';
                if($type == "หน้าร้าน"){
                    $query = "SELECT amount FROM shop WHERE prod_id = '$prod_id' AND shop_id = '$ware_id'";
                    $result1 = mysqli_query($conn, $query);
                    if($result1 && mysqli_num_rows($result1) > 0){    
                        while($row1 = mysqli_fetch_array($result1)){      
                            $row['min_amount'] = $row1['amount'];
                        }   
                    }else{
                        $row['min_amount'] = 0;
                    }
                }else if($type == "โกดัง"){
                    $query = "SELECT amount FROM warehouse WHERE prod_id = '$prod_id' AND ware_id = '$ware_id'";
                    $result1 = mysqli_query($conn, $query);
                    if($result1 && mysqli_num_rows($result1) > 0){    
                        while($row1 = mysqli_fetch_array($result1)){      
                            $row['min_amount'] = $row1['amount'];
                        }   
                    }else{
                        $row['min_amount'] = 0;
                    }
                }
            }

            // แนบข้อมูลโฟลเดอร์ของสินค้า
            $pid_str = (string)$prod_id;
            if(isset($folder_map[$pid_str])){
                $row['folder_path'] = $folder_map[$pid_str]['path'];
                $row['folder_chain'] = $folder_map[$pid_str]['chain'];
            }else{
                $row['folder_path'] = '';
                $row['folder_chain'] = array();
            }

            $output[] = $row;
        }   
    }

    if($result){
        echo json_encode($output);		   
    }else{
        echo "fail";
    }
    mysqli_close($conn);
?>