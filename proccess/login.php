<?php  
	require_once '../config.php';
	
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = mysqli_escape_string($con,$_POST['username']);
		$password = mysqli_escape_string($con,$_POST['password']);

		$sql = "SELECT * FROM tb_user WHERE username='".$username."'";
		$query = mysqli_query($con,$sql);
		$rows = mysqli_num_rows($query);

		if($rows == 1){
			$sql = "SELECT * FROM tb_user WHERE username='".$username."' AND pass='".$password."'";
			$query = mysqli_query($con,$sql);
			$rows = mysqli_num_rows($query);

			if($rows == 1){
				session_start();
				$_SESSION['username'] = $username;	
			}
			else{
				echo 2;
			}
		}
		else{
			echo 1;
		}
	}
?>