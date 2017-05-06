<?php  
	$con = mysqli_connect("localhost","root","","pro_cart");
	if(!$con){
		echo mysqli_error($con);
	}

	//Discontinue
	function query_slc($con,$tb_name){
		$sql = "SELECT * FROM ".$tb_name;
		$query = mysqli_query($con,$sql);
		$rows = mysqli_num_rows($query);
	}

	function adv_query_slc($con,$tb_name,$condition){
		$sql = "SELECT * FROM ".$tb_name." WHERE ".$condition;
		$query = mysqli_query($con,$sql);
		$rows = mysqli_num_rows($query);
	}
?>