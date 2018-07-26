<?php

session_start();

require_once "config.php";

$error=NULL;

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$site=$_SESSION["site"];
	$id=$_SESSION["userId"];	
	$query = "CALL deleteAccount('$id','$site')";
	if($link->query($query)) {
		$_SESSION["site"] = NULL;
		header('location: dashboard.php');
	}
	else
		$error = "Something went wrong. Please try again.";
}

$link->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
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
	<h2>Deleting your account will remove your account from this website only.</h2><br><br>
	Proceed at your own risk<br><br>
	<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
		<input type="submit" value="Delete Account">
	</form><br><br>
	<?php echo $error; ?>
	<div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
