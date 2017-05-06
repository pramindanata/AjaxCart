<?php 
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:login.php");
	}
	require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery.js"></script>
	<style type="text/css">
		body{
			margin: 0px;
			padding: 0px;
		}
		body>div,#content{
			padding: 15px;
		}
	</style>
</head>
<body>
	<div>
		<h2>TOKO PRO</h2>
		<p><?php echo "Hai ".$_SESSION['username'] ?></p>
		<ul>
			<li><a href="#items">Home</a></li>
			<li><a href="#cart">Keranjang</a></li>
			<li><a href="logout.php">Keluar</a></li>
		</ul>
	</div>
	<div id="content">

	</div>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		checkURL();
		$("ul li a").click(function(){
			checkURL(this.hash);
		});
		setInterval(checkURL(),250);

		if(window.location.hash == ""){
			$("#content").load("items.php");
		}
	});

	var lastURL = "";

	function checkURL(hash){
		if(!hash){
			hash = window.location.hash;
		}

		if(hash != lastURL){
			lastURL = hash;
			loadPage(hash);
		}
	}

	function loadPage(url){
		var url = url.replace("#","");

		$("#content").load(url+".php",function(response,status){
			if(status=="error"){
				$("#content").html("<p>No Data</p>");
			}
		});
	}
</script>
</html>