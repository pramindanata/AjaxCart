<?php 
	require_once '../config.php';
	session_start();
	if(isset($_GET['id'])){
		$_GET['id'] = intval($_GET['id']);
		$sql = "DELETE FROM ".$_SESSION['username']."_cart WHERE id_barang=".$_GET['id'];
		mysqli_query($con,$sql);
	}
	else{
		header("location:../index.php#cart");
	}
?>