<?php
	include "db.php";
	$name = $_POST['name'];	
	$pass = $_POST['pass'];	
    
	// Check pass match 
	$sql_pass = "SELECT user_id,pass,user_role FROM user WHERE user_name = '$name'";
	$res_pass = mysqli_query($conn, $sql_pass);

	if(mysqli_num_rows($res_pass) > 0){
		while($row = mysqli_fetch_array($res_pass)){
			if(password_verify($pass, $row['pass'])){
				$output[] = $row;
				echo json_encode($output);
			}else{
                echo "fail";                
			}		
		}		
	}else{
		echo "fail";
	}
	mysqli_close($conn);
?>