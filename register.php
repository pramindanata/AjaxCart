<?php  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<script type="text/javascript" src="jquery.js"></script>
</head>
<body>
	<div>
		<h2>Register Toko Pro</h2>
	</div>
	<div>
		<form>
			<label>Username</label>
			<input type="text" name="username" required="on" id="username"><br>
			<label>Password</label>
			<input type="password" name="pass" required="on" id="password">

			<input type="submit" name="submit" value="Register">
			<input type="reset" name="reset" value="Reset">
		</form>
	</div>
</body>
<script type="text/javascript">
	$("form").submit(function(e){
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		e.preventDefault();
		$.ajax({
			type : "POST",
			url : "proccess/register.php",
			data : {
				username : username,
				password : password
			},
			success : function(data){
				if(data == 1){
					alert("Username telah terpakai");
				}
				else{
					window.location = "index.php";
				}
			},
			error : function(){
				alert("Register Gagal");
			}
		});
	});
</script>

</html>