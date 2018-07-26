<?php
session_start();

require_once 'config.php';

$userId = $_SESSION["searchuid"];
$site = $_SESSION["searchSite"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if($_POST["social"] != "0") {
		$site = $_POST["social"];
		$_SESSION["searchSite"] = $site;
	}
}

$query = "SELECT * FROM socialMedia WHERE accId=fetchId('$userId','$site')";
$result= $link->query($query);
$extract=$result->fetch_assoc();
$username=$extract['username'];
$gender=($extract['gender']=="M")?"Male":"Female";
$fname=$extract['firstName'];
$lname=$extract['lastName'];
$mode=$extract['mode'];
$type=$extract['type'];
$bio=$extract['bio'];

if(empty($username)) 
		header('location: viewnoaccount.php');


?>
<html>
<head>
<title>Profile Page</title>
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
			<a href="dashboard.php">Dashboard</a><em>|</em><a href="logout.php">Logout</a><br>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<select name="social">
					<option value="0">--SELECT--</option>
					<option value="Facebook">Facebook</option>
					<option value="Instagram">Instagram</option>
					<option value="Twitter">Twitter</option>
					<option value="Google +">Google +</option>
				</select>
				<input type="submit" value="Go"><br><hr>	
			</form>
		</div>
		<h2><?php echo $site; ?></h2><br>
		<br><hr>
	<br>
	<h1><?php echo $fname; ?>'s <?php echo $site; ?>'s Profile</h1><br><hr>
	<img src="<?php echo $extract['media']; ?>" width=200 height=200><br><br>
	<table width="50%" align="center">
	<tr>
	<th width="50%">
	<th width="50%">
	</tr>
	<tr>
	<td align="center">Username:</td><td align="center"><?php echo $username; ?></td>
	</tr>
	<td align="center">First Name:</td>
	<td align="center"><?php echo $fname; ?></td>
	</tr>
	<tr>
	<td align="center">Last Name:</td>
	<td align="center"><?php echo $lname; ?></td>
	</tr>
	<tr>
	<td align="center">Gender:</td>
	<td align="center"><?php echo $gender; ?></td>
	</tr>
	<tr>
	<td align="center">Type:</td>
	<td align="center"><?php echo $type; ?></td>
	</tr>
	<tr>
	<td align="center">Mode:</td>
	<td align="center"><?php echo $mode; ?></td>
	</tr>
	<tr>
	<td align="center">Bio:</td>
	<td align="center"><?php echo $bio; ?></td>
	</tr>
	</table><br><br><hr><br><br>
	<?php
		if($mode == "private")
			echo "You cannot view ".$fname."'s posts.";
		else {
			echo "<table width=\"100%\" border=0>";
			echo "<tr>";
			echo "<th width=\"50%\" bgcolor=\"yellow\"><a href=\"viewpost.php\">Posts</a></th>";
			echo "</tr>";
			echo "</table>";
		} ?>

	<div class="footer">
			<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
	<?php $link->close(); ?>
</body>
</html>
