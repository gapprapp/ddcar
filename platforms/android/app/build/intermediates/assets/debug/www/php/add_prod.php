<?php
    include "db.php";
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $server = "ftp://migky.myqnapcloud.com";
    $serverPort = 22;
    $serverUser = "admin";
    $serverPassword = "MigkyOpas25538";
    $server_path = "/Web/dd-shop/image/". $file_name;
    $path_img = "migky.myqnapcloud.com/Web/dd-shop/image/" . $file_name;
    $name  = $_GET['name_prod'];    
    $code  = $_GET['code'];   
    $parent  = $_GET['parent'];    
    $min = $_GET['min'];  
    
    echo $file_name;
    
    /*$ftp_conn = ftp_ssl_connect($server);
    $login = ftp_login($ftp_conn, $serverUser, $serverPassword);
    if($login){
      echo "success";
    }else{
      echo "fail";
    }*/
    //ftp_pasv($ftp_conn, true);
    /*if(ftp_put($ftp_conn, $server_path , $file_tmp, FTP_BINARY)){
      mysqli_begin_transaction($conn);
      $sql = "INSERT INTO product(prod_name,prod_code,img,min_amount) VALUE ('$name','$code','$path_img','$min')";
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
    }else{
      echo "fail";
      exit;
    }*/
    //ftp_close($ftp_conn); 
    /*$connection = ssh2_connect($server, $serverPort);
    $bool = false;
    if(ssh2_auth_password($connection, $serverUser, $serverPassword)){
      ssh2_scp_send($connection, $file_tmp, $server_path,0777);
      ssh2_exec($connection, 'exit');       
      $bool = true;
    } else {      
      echo "fail";
      exit;    
    }*/  
    /*if($bool){
      mysqli_begin_transaction($conn);
      $sql = "INSERT INTO product(prod_name,prod_code,img,min_amount) VALUE ('$name','$code','$path_img','$min')";
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
    }*/
?>