<?php 

session_start();
if (isset($_SESSION['loggedin'])){
header("Location:home.php");

} 
 require 'config.php';
if(isset($_POST["username"]) && !empty($_POST["username"]))
{
	$_SESSION['sentmail'] = $_POST["username"];
	
	if ($stmt = $con->prepare('SELECT email password FROM accounts WHERE username = ?')) {
		
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		
		$stmt->store_result();
	
	
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($email);
			$stmt->fetch();
			require_once("m_Mail.php");
			$token =bin2hex(openssl_random_pseudo_bytes(30));
			sendMail($email,'Password Reset','this is your token : '.$token);
			
			$stmt = $con->prepare('INSERT INTO `passwors_reset`(`reset_key`, `username`) VALUES (?,?)');
			$user= $_POST['username'];
			
			
					$stmt->bind_param('ss',$token, $user);
				if($stmt->execute())
				{
					
				}else{
					echo('error : '.$stmt->error);
				}
					$stmt->close();
		}
		$stmt->close();
	}

}	


if(isset($_SESSION['sentmail']) && !empty($_SESSION['sentmail']) && isset($_POST['pin']) && !empty($_POST['pin'])){

	$stmt = $con->prepare('SELECT reset_key password FROM passwors_reset WHERE username = ? order by created_at desc');
		
		$stmt->bind_param('s', $_SESSION['sentmail']);
		$stmt->execute();
		
		$stmt->store_result();
	
	
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($rsKey);
			$stmt->fetch();
			if($rsKey == $_POST['pin'])
			{
					$_SESSION['Reset']=true;
			}
		}else
		{
			$_SESSION['sentmail']=null;
			
		} 
		
		
}


$cango=true;

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
			<h1>Password Resset</h1>
			<form  method="post">
			<?php if (!isset($_SESSION['sentmail'])){?>

				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<input type="submit" value="Send">

			<?php }else if(isset($_SESSION['sentmail']) && !isset($_SESSION['Reset'])){?>
				
				<label for="username">
					<i class="fas fa-slack"></i>
				</label>
				<input type="text" name="pin" placeholder="pin" id="pin" required>
				<h1>We sent you an email</h1>
				<input type="submit" value="Validate">

				<?php }else{?>

					<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="password" id="password" required>
				
				<label for="confirmpassword">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="confirmpassword" placeholder="confirm password" id="confirmpassword" required>

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
				<input type="submit" value="Change">
				
				<?php } ?>
				
			</form>
		</div>
		<div class="login" style="padding:10px">
            <a href="home.php">Go to home as guest</a>
            <br>
            <a href="register.php">Register</a>
            <br>
            <a href="index.php">Login</a>
        </div>
	</body>
</html>
<?php
if(isset($_POST['confirmpassword']) && isset($_POST['password']) && $cango==true)
{

				$stmt = $con->prepare('DELETE FROM `passwors_reset` WHERE `username` = ?');
				$stmt->bind_param('s',$_SESSION['sentmail'] );
				if($stmt->execute())
				{
					$stmt->close();
					$pass = password_hash($_POST['password'],PASSWORD_DEFAULT); 
					$stmtA = $con->prepare('UPDATE `accounts` SET `password`= ? WHERE `username` = ?');
					$stmtA->bind_param('ss',$pass,$_SESSION['sentmail'] );
				
					if($stmtA->execute())
					{
						session_destroy();
						header("Location:index.php");
					}

				}else{
					echo('error : '.$stmt->error);
				}
					$stmt->close();
				
}?>