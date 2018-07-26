<?php 

require_once 'config.php';

session_start();

	$userId = $_SESSION["userId"];
	$site = $_GET["social"];
	if($site=="Google")
		$site = "Google +";
	$query = "SELECT autobio('$site','$userId') as bio";
	$result = $link->query($query);
	$result = $result->fetch_assoc();
	$bio = $result["bio"];
	$_SESSION["bio"] = $bio;
	header('location: editprofile.php');

$link->close();

?>
