<?php 
session_start();
if (isset($_SESSION['loggedin'])){
header("Location:home.php");
} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
		</div>

        <div class="login" style="padding:10px">
            <a href="home.php">Go to home as guest</a>
            <br>
            <a href="register.php">Register</a>
            <br>
            <a href="resetPassword.php">Forgot Password</a>
        </div>

	</body>
</html>