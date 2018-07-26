<?php


session_start();

$userId = $_SESSION["userId"];

require_once "config.php";

$username_err=$password_err=$error= $site_err=NULL;
$username=$password="";

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = $_POST["user"];
	
	$password = $_POST["pass"];
	$site = $_POST["site"];
	
	if($site == "0")
		$site_err = "Please select a social media platform.";
	if(empty($username))
		$username_err = "Please enter a username.";

	if(empty($password))
		$password_err = "Please enter a password.";

	if(empty($username_err) && empty($password_err) && empty($site_err)) {

		$query = "SELECT accId FROM socialMedia WHERE username='$username' AND site='$site'";
		if($result = $link->query($query)) {
			if($result->num_rows == 1)
					$username_err = "Account already exists";
			else {
				$query = "SELECT * FROM socialMedia WHERE accId=fetchId('$userId','$site')";
				$result = $link->query($query);
				if($result->num_rows == 1)
					$username_err = "Username taken";
				else {
					$sql = "CALL addAccount('$userId','$username','$password','$site')";
					if($link->query($sql) === true)
						header('location: successacc.php');
					else
						$error = "Unexpected error! Please try again.";	
				}
			}
				
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
		<title>Add Account</title>
		<style>
			.footer {
			    position: fixed;
			    left: 0;
			    bottom: 0;
			    width: 100%;
			    text-align: center;
			}
		</style>
	</head>

	<body align="center">
		<div align="right">
			<a href="dashboard.php">Dashboard</a><em>|</em><a href="logout.php">Logout</a><br><hr>
		</div>
		<h2>Add a Social Media account</h2>
		
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label>Social Media Site:</label>
			<select name="site">
				<option value="0">--SELECT--</option>
				<option value="Facebook">Facebook</option>
				<option value="Twitter">Twitter</option>
				<option value="Instagram">Instagram</option>
				<option value="Google +">Google +</option>
			</select><br>
			<?php echo $site_err; ?><br><br><br>
			<label>Username:<br></label>
			<input type="text" name="user" value=""><br>
			<?php echo $username_err; ?><br>
			<label>Password:<br></label>
			<input type="password" name="pass" value=""><br>
			<?php echo $password_err; ?><br>
			<input type="submit" value="Log In"><br>
			<?php echo $error; ?><br>
		</form>
		<br><br><br>
		<div class="footer"><hr>
		<i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
		</div>
	</body>
</html>
