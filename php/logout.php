<?php

session_start();

require_once "config.php";

$username = $_SESSION["username"];

$query = "UPDATE users SET lastonline=NOW() WHERE username='$username'";

$link->query($query);

$link->close();

session_destroy();

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
	<br><br><br>
	You've been logged out successfully!<br><br>Go to:<br><br>
	<a href="../index.html">Home</a> | <a href="login.php">Login</a>
	
	<div class="footer">
	<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
