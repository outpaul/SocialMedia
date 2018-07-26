<?php
session_start();

require_once 'config.php';

$userId=$_SESSION["userId"];

if(isset($_GET["user"])) {
	$username = $_GET["user"];
	$_SESSION["searchuser"] = $username;
}
else
	$username = $_SESSION["searchuser"];

$query = "SELECT * FROM users WHERE username='$username'";
  $result= $link->query($query);
  $extract=$result->fetch_assoc();
  $gender=($extract['gender']=="M")?"Male":"Female";
  $fname=$extract['firstName'];
  $lname=$extract['lastName'];
  $last=$extract['lastonline'];
  $bio=$extract['bio'];
  $searchId=$_SESSION["searchuid"]=$extract['userId'];

$sql = "CALL interest('$userId','$searchId')";
$result = $link->query($sql);

$_SESSION["searchname"] = $fname;

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST["site"] != "0") {
		$_SESSION["searchSite"] = $_POST["site"];
		echo $_SESSION["searchSite"];
		echo $_SESSION["searchuid"];
		header('location: viewaccount.php');
	}
}

$link->close();

?>
<html>
<head>
<title>Profile Page</title>
<style>
		.footer {
		    left: 0;
		    bottom: 0;
		    width: 100%;
		    text-align: center;
		}
		img {
			object-fit: cover;
		}
</style>
</head>

<body align="center">
<div align="right">
		<a href="dashboard.php">Dashboard</a><em>|</em><a href="logout.php">Logout</a><br><hr>
</div>
<br>
<h1><?php echo $fname; ?>'s Profile</h1><br><hr>
<img src="<?php echo $extract['image']; ?>" width=200 height=200><br><br>
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
<td align="center">Bio:</td>
<td align="center"><?php echo $bio; ?></td>
</tr>
<tr>
<td align="center">Last Online:</td>
<td align="center"><?php echo $last; ?></td>
</tr>
</table><br><br>
View <?php echo $fname; ?>'s accounts:<br><br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<select name="site">
			<option value="0">--SELECT--</option>
			<option value="Facebook">Facebook</option>
			<option value="Instagram">Instagram</option>
			<option value="Twitter">Twitter</option>
			<option value="Google +">Google +</option>
		</select>
		<input type="submit" value="Go"></form><br><br>Also view: <br><br>

<table width="100%" border=0>
			<tr>
				<th width="50%" bgcolor="yellow"><a href="viewallpost.php">Posts</a></th>
			</tr>
		</table><br><br>
<div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
</div>
<?php $link->close(); ?>
</body>
</html>
