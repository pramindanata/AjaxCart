<title>Keranjang</title>
<?php 
	require_once 'config.php';
	session_start(); 
?>
<style type="text/css">
	body{
		position: relative;
	}
	table, th, td {
	    border: 1px solid black;
	    border-collapse: collapse;
	}
	td{
		padding: 5px 3px;
	}
	.jumlah{
		width: 30px;
	}
	.payment{
		visibility: hidden;
	    width: 100vw;
	    height: 100vh;
	    background: rgba(0, 0, 0, 0.73);
	    display: flex;
	    position: absolute;
	    top: 0px;
	    margin: 0px -15px;
	}
	.payment>div{
		position: relative;
		margin: auto;
	}
	.payment>div>div{
		background: white;
		text-align: center;
		padding: 15px 15px;
		position: relative;
	}
	.payment>div>div>.close{
		position: absolute;
		top: 5px;
		right: 5px;
	}
	.payment>div>div>h4{
		margin-top: 0px;
	}
	.bayar{
		margin-top: 10px;
	}
</style>
<div class="cart">
	<h3>Keranjang Anda</h3>
	<div class="table">
		<table >
			<thead>
				<tr>
					<th>Nama Barang</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$sql = "SELECT tb_item.id_barang AS id, tb_item.nama AS nama, tb_item.harga AS harga, ".$_SESSION['username']."_cart.jumlah AS jumlah, (".$_SESSION['username']."_cart.jumlah*tb_item.harga) AS total FROM ".$_SESSION['username']."_cart INNER JOIN tb_item ON ".$_SESSION['username']."_cart.id_barang = tb_item.id_barang";
					$query = mysqli_query($con,$sql);
					while ($data = mysqli_fetch_array($query)) {
						?>
							<tr item-id="<?php echo $data['id'] ?>">
								<td><?php echo $data['nama'] ?></td>
								<td><?php echo $data['harga'] ?></td>
								<td>
									<button class="min">-</button>
									<input class="jumlah" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $data['jumlah'] ?>">
									<button class="plus">+</button>
								</td>
								<td><?php echo $data['total'] ?></td>
								<td><button class="hapus">Hapus</button></td>
							</tr>
						<?php
					}		
				?>
			</tbody>
		</table>
	</div>

	<div>
		<p><b>Total : </b><span class="total"></span></p>
		<button class="openBayar">Bayar</button>
	</div>

	<div class="payment">
		<div>
			<div>
				<button class="close">
					<span>x</span>
				</button>
				<h4>Pembayaran</h4>
				<p>Total : </b><span class="total"></span></p>
				<input type="number" min="1" name="pay" class="payAmount" placeholder="Masukan jumlah pembayaran"><br>
				<p>Kembali : </b><span class="kembali">0</span></p>
				<button class="bayar">Bayar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		check_cart();
		total();
	});

	function check_cart(){
		$.ajax({
			type : "GET",
			url : "proccess/check_cart.php",
			data : "check=check",
			success : function(data){
				if(data == "clear"){
					$(".cart").children(".table").html("<h5>Keranjang Anda Kosong.</h5>")
				}
			}
		});
	}

	$(".jumlah").keyup(function(){
		if(this.value == ""){
			this.value = 1;
		}
		var row = $(this).parent().parent().index();
		var id = $(this).parent().parent().attr("item-id");
		direct(this.value,row,id);
	});
	function direct(value,row,id){
		$.ajax({
			type : "POST",
			url : "proccess/amount.php",
			data : {
				mode : "direct",
				value : value,
				id : id
			},
			success : function(data){
				var price = $("tr")[row+1].children[1].innerHTML;
				
				$("tr")[row+1].children[2].children[1].value = data;
				$("tr")[row+1].children[2].children[1].setAttribute("value",data);
				$("tr")[row+1].children[3].innerHTML = price*data;
				total();
			},
			error : function(){
				alert("Proses gagal");
			}
		});
	}

	$(".min").click(function(){
		var row = $(this).parent().parent().index();
		var id = $(this).parent().parent().attr("item-id");
		decrease(row,id);
	});
	function decrease(row,id){
		$.ajax({
			type : "POST",
			url : "proccess/amount.php",
			data : {
				mode : "decrease",
				id : id
			},
			success : function(data){
				var price = $("tr")[row+1].children[1].innerHTML;
				
				$("tr")[row+1].children[2].children[1].value = data;
				$("tr")[row+1].children[2].children[1].setAttribute("value",data);
				$("tr")[row+1].children[3].innerHTML = price*data;
				total();
			},
			error : function(){
				alert("Proses gagal");
			}
		});
	}

	$(".plus").click(function(){
		var row = $(this).parent().parent().index();
		var id = $(this).parent().parent().attr("item-id");
		increase(row,id);
	});
	function increase(row,id){
		$.ajax({
			type : "POST",
			url : "proccess/amount.php",
			data : {
				mode : "increase",
				id : id
			},
			success : function(data){
				var price = $("tr")[row+1].children[1].innerHTML;

				$("tr")[row+1].children[2].children[1].value = data;
				$("tr")[row+1].children[2].children[1].setAttribute("value",data);
				$("tr")[row+1].children[3].innerHTML = price*data;
				total();
			},
			error : function(){
				alert("Proses gagal");
			}
		});
	}

	$(".hapus").click(function(){
		var row = $(this).parent().parent().index();
		var id = $(this).parent().parent().attr("item-id");
		hapus(row,id);
	});
	function hapus(row,id){
		$.ajax({
			type : "GET",
			url : "proccess/delete_item.php",
			data : "id="+id,
			success : function(data){
				$("tr")[row+1].remove();
				total();
				check_cart();
			},
			error : function(){
				alert("Proses gagal");
			}
		});
	}

	function total(){
		$.ajax({
			type : "GET",
			url : "proccess/amount.php",
			data : "mode=total",
			success : function(data){
				$(".total").text(data);
			},
			error : function(){
				alert("Proses gagal");
			}
		});
	}

	$(".openBayar").click(function(){
		$(".payment").css("visibility","visible");
	});
	$(".close").click(function(){
		$(".payment").css("visibility","hidden");
		document.getElementsByClassName("kembali")[0].innerHTML = 0;
		$(".payAmount").val("");
	});
	$(".payAmount").keyup(function(){
		var totalPay = parseInt(document.getElementsByClassName("total")[0].innerHTML);
		var inputPay = parseInt($(".payAmount").val());
		document.getElementsByClassName("kembali")[0].innerHTML = inputPay-totalPay;
	});
	$(".bayar").click(function(){
		$.ajax({

		});
	});
</script>