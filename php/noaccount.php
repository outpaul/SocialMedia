<?php

session_start();

$site = $_SESSION["site"];

$_SESSION["site"] = NULL;

require_once "config.php";

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
	<h2>Sorry! You do not have a <?php echo $site; ?> account connected to this website.</h2><br><br>
	Add account <a href="addaccount.php">here</a><br><hr>.
	<div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
