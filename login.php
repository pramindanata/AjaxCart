<?php  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<script type="text/javascript" src="jquery.js"></script>
</head>
<body>
	<div>
		<h2>Login Toko Pro</h2>
	</div>
	<div>
		<form>
			<label>Username</label>
			<input type="text" name="username" required="on" id="username"><br>
			<label>Password</label>
			<input type="password" name="pass" required="on" id="password">

			<input type="submit" name="submit" value="Login">
			<input type="reset" name="reset" value="Reset">
		</form>
		<p>Gak punya akun ? Silahkan <a href="register.php">register</a></p>
	</div>
</body>
<script type="text/javascript">
	$("form").submit(function(e){
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		e.preventDefault();

		$.ajax({
			type : "POST",
			url : "proccess/login.php",
			data : {
				username : username,
				password : password
			},
			success : function(data){
				if(data == 1){
					alert("Username tidak terdaftar");
				}
				else if(data == 2){
					alert("Password salah");
				}
				else{
					window.location = "index.php";
				}
			},
			error : function(){
				alert("Gagal login");
			}
		});
	});
</script>
</html>