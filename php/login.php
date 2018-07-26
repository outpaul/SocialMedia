<?php


require_once "config.php";

$username_err=$password_err=$error=NULL;
$username=$password="";

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = $_POST["user"];
	
	$password = $_POST["pass"];
	
	if(empty($username))
		$username_err = "Please enter a username.";

	if(empty($password))
		$password_err = "Please enter a password.";

	if(empty($username_err) || empty($password_err)) {

		$query = "SELECT userId,firstName,password FROM users WHERE username='$username'";
		if($result = $link->query($query)) {
			if($result->num_rows == 1) {
				$ar = $result->fetch_assoc();
				if($password == $ar['password']) {
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['name'] = $ar['firstName'];
					$_SESSION['userId'] = $ar['userId'];
					header('location: dashboard.php');
				}
				else
					$password_err = "Incorrect password";
			}
			else
				$username_err = "Username does not exist.";
		}
		else
		$error = "Unexpected error! Please try again.";
	}
}

$link->close();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Log In</title>
		<style>
			.footer {
			    left: 0;
			    bottom: 0;
			    width: 100%;
			    text-align: center;
			}
		</style>
	</head>
	<body align="center">
		<h2>Log In</h2>
		<p>Log in with your credetials<br></p>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label>Username:<br></label>
			<input type="text" name="user" value=""><br>
			<?php echo $username_err; ?><br>
			<label>Password:<br></label>
			<input type="password" name="pass" value=""><br>
			<?php echo $password_err; ?><br>
			<input type="submit" value="Log In"><br>
			<?php echo $error; ?><br>
		</form>
		<p>Don't have an account? <a href="signup.php">Create your own.</a></p>
		<div class="footer">
			<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
		</div>
	</body>
</html>

