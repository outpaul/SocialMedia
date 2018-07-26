<?php

session_start();

$site = $_SESSION["searchSite"];
$name = $_SESSION["searchname"];

$_SESSION["searchname"] = NULL;

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
	<h2>Sorry! <?php echo $name; ?> does not have a <?php echo $site; ?> account connected to this website.</h2><br><br>
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
