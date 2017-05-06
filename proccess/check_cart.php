<?php 
	require_once '../config.php';
	session_start();

	if(isset($_GET['check'])){
		$sql = "SELECT * FROM ".$_SESSION['username']."_cart";
		$query = mysqli_query($con,$sql);
		if(mysqli_num_rows($query) == 0){
			echo "clear";
		}
	}
	else{
		header("location:../index.php#cart");
	}
?>