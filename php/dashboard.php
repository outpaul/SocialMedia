<?php

session_start();

$_SESSION["search"] = NULL;
$_SESSION["para"]  = NULL;

if($_SERVER["REQUEST_METHOD"] == "GET") {
	$_SESSION["site"] = NULL;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST["search"])) {
		$_SESSION["search"] = $_POST["search"];
		$_SESSION["para"] = $_POST["para"];
		header('location: search.php');
		
	}
	else if(isset($_POST["social"])) {
		$site = $_POST["social"];
		if($site != "0") {
			$_SESSION["site"] = $site;
			header('location: account.php');	
		}	
	}		
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
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
		Dashboard<em>|</em><a href="logout.php">Logout</a><br><hr>
	</div>
	<?php echo "<h1>Welcome ".$_SESSION["name"]."!</h1>"; ?><br>
	<p>View your profile <a href="profile.php">here.</a></p><br><br>
	Search other users: <br><br>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="radio" name="para" value="name" checked>Name &nbsp &nbsp &nbsp &nbsp
		<input type="radio" name="para" value="uid">Username<br><br>
		<input type="text" name="search" value="">
		<input type="submit" value="Search">
	</form><br><br><hr>
	
	<p>Select your social media account.<br></p>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<select name="social">
			<option value="0">--SELECT--</option>
			<option value="Facebook">Facebook</option>
			<option value="Instagram">Instagram</option>
			<option value="Twitter">Twitter</option>
			<option value="Google +">Google +</option>
		</select>
		<input type="submit" value="Go">	
	</form><h5>OR</h5>
	<form action="addaccount.php" method="get">
		<input type="submit" value="Add account">
	</form>
	<br><br>
	<table width="100%" border=0>
			<tr>
				<th width="50%" bgcolor="yellow"><a href="allpost.php">Posts</a></th>
				<th width="50%" bgcolor="yellow"><a href="allmessage.php">Messages</a></th>
			</tr>
		</table>
	<br><br><br>
	<div class="footer">
	<form action="deleteuser.php" method="get">
		<input type="submit" value="Delete Account">	
	</form><br><br><br>
	<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
