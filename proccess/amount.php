<?php 
	require_once '../config.php';
	session_start();
	if(isset($_POST['mode']) && isset($_POST['id'])){
		$sql = "SELECT * FROM ".$_SESSION['username']."_cart WHERE id_barang=".$_POST['id'];
		$query = mysqli_query($con,$sql);
		if(mysqli_num_rows($query) == 1){
			if($_POST['mode'] == "decrease"){
				$sql_ck_jum = "SELECT jumlah FROM ".$_SESSION['username']."_cart WHERE id_barang=".$_POST['id'];
				$query_ck_jum = mysqli_query($con,$sql_ck_jum);
				$data_jum = mysqli_fetch_array($query_ck_jum);

				if($data_jum['jumlah'] == 1){
					echo 1;
					die();
				}
				else{
					$sql = "UPDATE ".$_SESSION['username']."_cart SET jumlah=jumlah-1 WHERE id_barang=".$_POST['id'];
				}
			}
			if($_POST['mode'] == "increase"){
				$sql = "UPDATE ".$_SESSION['username']."_cart SET jumlah=jumlah+1 WHERE id_barang=".$_POST['id'];
			}
			if($_POST['mode'] == "direct"){
				$sql = "UPDATE ".$_SESSION['username']."_cart SET jumlah=".$_POST['value']." WHERE id_barang=".$_POST['id'];
			}
				
			mysqli_query($con,$sql);

			$sql = "SELECT * FROM ".$_SESSION['username']."_cart WHERE id_barang=".$_POST['id'];
			$query = mysqli_query($con,$sql);
			$data = mysqli_fetch_array($query);

			echo $data['jumlah'];
		}
		else{
			echo "Barang tidak ada di keranjang";
		}
	}
	else if(isset($_GET['mode']) == "total"){
		$sql = "SELECT sum(eksa_cart.jumlah*tb_item.harga) AS total FROM eksa_cart INNER JOIN tb_item ON eksa_cart.id_barang = tb_item.id_barang";
		$query = mysqli_query($con,$sql);
		$data = mysqli_fetch_array($query);

		echo $data['total'];
	}
	else{
		header("location:../index.php#cart");
	}
?>