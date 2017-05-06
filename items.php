<title>Home</title>
<style type="text/css">
	.list>div>.list-item{
		border : solid #000 2px;
		width: 20%;
		padding:15px;
		float: left;
		height: 250px;
		margin: 0px 10px;
		text-align: center;
	}
	.list>div>.list-item>img{
		width: 150px;
	}
	.alert{
		visibility: hidden;
		position: absolute;
	    left: 0px;
	    right: 0px;
	    width: 300px;
	    border: solid;
	    background-color: #fff;
	    text-align: center;
	    bottom: 15px;
	    margin-left: auto;
	    margin-right: auto;
	}
</style>
<?php 
	require_once 'config.php'; 
?>
<div class="list">
	<div class="alert">
		<p id="text"></p>
	</div>
	<div>
	<?php  
		$sql = "SELECT * FROM tb_item";
		$query = mysqli_query($con,$sql);
		while ($data = mysqli_fetch_array($query)) {
			?>
				<div class="list-item" id="<?php echo $data['id_barang'] ?>">
					<h3><?php echo $data['nama'] ?></h3>
					<img src='<?php echo $data['img'] ?>'>
					<p>Harga :<?php echo " ".$data['harga'] ?></p>
					<button>Beli</button>
				</div>
			<?php
		}
	?>
	</div>

	<script type="text/javascript">
		$("button").click(function(){
			beli($(this).parent().attr("id"));
		});

		function beli(id){
			$.ajax({
				type : "POST",
				url : "proccess/tocart.php",
				data : "item="+id,
				success : function(data){
					$(".alert").css("visibility","hidden");
					$("#text").text(data);
					$(".alert").css("visibility", "visible");
					setTimeout(function(){
						$(".alert").css("visibility","hidden");
					},3000);
				},
				error : function(){
					alert("Gagal");
				}
			});
		}
	</script>
</div>