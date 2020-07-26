<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Auth Website </h1>
                <?php if (isset($_SESSION['loggedin'])) {?>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                <?php }else{ ?>
                    <a href="index.php"><i class="fas fa-user"></i>Login</a>
                <?php }?>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
            <?php if (isset($_SESSION['loggedin'])) {?>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
            <?php }else{ ?>
                <p>Welcome <b>Guest</b>, you are not logged in !  <a href="index.php"><br> Login</a></p>
                
                <?php }?>
		</div>
	</body>
</html>