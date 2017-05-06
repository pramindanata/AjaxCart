<?php  
	if(isset($_POST['item'])){
		session_start();
		require_once '../config.php';

		$item = $_POST['item'];

		//Fungsi masukin barang baru
		function barang_baru($con,$barang){
			$sql = "INSERT INTO ".$_SESSION['username']."_cart VALUES(null,".$barang.",1)";
			$query = mysqli_query($con,$sql);
			if(!$query){
				echo "Barang gagal dimasukan";
			}
			else{
				$sql = "SELECT * FROM tb_item WHERE id_barang=".$barang;
				$query = mysqli_query($con,$sql);
				$data = mysqli_fetch_array($query);
				echo "'".$data['nama']."' dimasukan ke keranjang anda";
			}
		}

		$sql = "SHOW TABLES LIKE '".$_SESSION['username']."_cart'";
		$query = mysqli_query($con,$sql);

		//Masukan barang baru ketika tabel cart belum ada
		if(mysqli_num_rows($query) == 0){
			$sql = "CREATE TABLE ".$_SESSION['username']."_cart(
				id int(5) AUTO_INCREMENT,
				id_item int(5),
				jumlah int(3),
				PRIMARY KEY (id)
			)";

			if(!mysqli_query($con,$sql)){
				echo mysqli_error($con);
			}
			else{
				barang_baru($con,$item);
			}
		}

		//Setelah tabel cart ada
		else{
			$sql = "SELECT * FROM ".$_SESSION['username']."_cart WHERE id_barang=".$item;
			$query = mysqli_query($con,$sql);
			$row = mysqli_num_rows($query);

			//Update barang kalau barang sudah masuk ke cart sebelumnya.
			if($row){
				$sql = "UPDATE ".$_SESSION['username']."_cart SET jumlah=jumlah+1 WHERE id_barang=".$item;
				if(!mysqli_query($con,$sql)){
					echo "Barang gagal dimasukan";
				}
				else{
					$sql = "SELECT * FROM tb_item WHERE id_barang=".$item;
					$query = mysqli_query($con,$sql);
					$data = mysqli_fetch_array($query);
					echo "Jumlah barang '".$data['nama']."' ter-update";
				}
			}
			//Kalau tidak, tambah barang baru.
			else{
				barang_baru($con,$item);
			}
		}
	}
?>