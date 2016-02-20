<html>
<head>
	<title>Login</title>
</head>
<body>
	<?php if(isset($_GET['error']) && $_GET['error'] == '1') echo "<span style='color:red'>You shall not pass!</span><br>"; ?>
	<form name="login" method="post" action="php/login.php">
		<label for="username">Username: </label>
		<input type="text" maxlength="20" name="username" id="username"></input></br>
		<label for="password">Password: </label>
		<input type="password" maxlength="16" name="password" id="password"></input></br>
		<input type="submit" value="Login"></input>
	</form>
</body>
</html>