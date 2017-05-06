<?php
	require_once '../config.php';
	
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = mysqli_escape_string($con,$_POST['username']);
		$password = mysqli_escape_string($con,$_POST['password']);

		$sql = "SELECT * FROM tb_user WHERE username='".$username."'";
		$query = mysqli_query($con,$sql);
		$rows = mysqli_num_rows($query);

		if($rows != 0){
			echo 1;
		}
		else{
			$sql = "INSERT INTO tb_user VALUES(null,'".$username."','".$password."')";
			$query = mysqli_query($con,$sql);
			if(!$query){
				echo "Register gagal";
			}
			else{
				session_start();
				$_SESSION['username'] = $username;
			}
		}
	}
?>