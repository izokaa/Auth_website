
<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
$cango =true;
include("config.php");
?>

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
			<h1>Register</h1>
			<form  method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				
				
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" name="email" placeholder="email" id="email" required>
				
				
				
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				
				

				<label for="confirmpassword">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="confirmpassword" placeholder="confirmpassword" id="confirmpassword" required>
			
			
			<div style="color:red">
				<?php
				
				if(isset($_POST['username']))
				{
					
					$stmt = $con->prepare('SELECT count(*) from accounts WHERE username = ?');
					$stmt->bind_param('s', $_POST['username']);
					$stmt->execute();
					$stmt->bind_result($count);
					$stmt->fetch();
					$stmt->close();
					if($count> 0)
					{
						$cango =false;
						echo "<b>- use another username </b> <br>";
					}
				}
				
				?>
				<?php 
				if(isset($_POST['email']) && !preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",$_POST['email']))
				{
					$cango =false;
					echo "<b>- email is not valid </b><br>";
				}
				?>
<?php 
				if(isset($_POST['password']) && !preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%]).{8,}/",$_POST['password']))
				{
					$cango =false;
					echo "<b>- the password should contain: <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;At least one digit<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;At least one lowercase character<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;At least one uppercase character<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;At least one special character<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;At least 8 characters in length
					</b><br>";
				}
				?>
			
				<?php 
				if(isset($_POST['confirmpassword']) && isset($_POST['password']) && $_POST['confirmpassword'] != $_POST['password'])
				{
					$cango =false;
					echo "<b>- Passwords are not identical </b><br>";
				}
				?>
				</div>
				
				<input type="submit" value="Register">
			</form>
		</div>
        <div class="login" style="padding:10px">
            <a href="index.php">Login</a>
			<br>
			<a href="resetPassword.php">Forgot password</a>
        </div>
	</body>
</html>
<?php
if(isset($_POST['confirmpassword']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['username']) && $cango==true)
{



				$stmt = $con->prepare('INSERT INTO `accounts`( `username`, `password`, `email`) VALUES (?,?,?)');
				$user= $_POST['username'];
				$mail =$_POST['email'];
				$pass=$_POST['password'];
					$stmt->bind_param('sss', $user,password_hash($pass,PASSWORD_DEFAULT),$mail);
				if($stmt->execute())
				{
					$stmt->close();
					header("Location:index.php");
				}else{
					echo('error : '.$stmt->error);
				}
					$stmt->close();
				
}

 ?>