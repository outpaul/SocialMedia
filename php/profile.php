<?php
session_start();

require_once 'config.php';

$username = $_SESSION["username"];
$userId = $_SESSION["userId"];

$query = "SELECT * FROM users WHERE username='$username'";
  $result= $link->query($query);
  $extract=$result->fetch_assoc();
  $gender=($extract['gender']=="M")?"Male":"Female";
  $fname=$extract['firstName'];
  $lname=$extract['lastName'];
  $contact=$extract['contact'];
  $email=$extract['email'];
  $dob=$extract['dob'];
  $bio=$extract['bio'];

$query = "SELECT * FROM location WHERE userId='$userId'";
$location = $link->query($query);

$query = "SELECT * FROM eduQual WHERE userId='$userId'";
$eduQual = $link->query($query);

$query = "SELECT * FROM work WHERE userId='$userId'";
$work = $link->query($query);

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
<h1>Profile</h1><br><hr>
<img class="pro" src="<?php echo $extract['image']; ?>" width=200 height=200><br><br>
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
<td align="center" >Bio:</td>
<td align="center"><?php echo $bio; ?></td>
</tr>
<tr>
<td align="center">Date of Birth:</td>
<td align="center"><?php echo $dob; ?></td>
</tr>
<tr>
<td align="center" >Contact:</td>
<td align="center"><?php echo $contact; ?></td>
</tr>
<tr>
<td align="center" >E-mail:</td>
<td align="center"><?php echo $email; ?></td>
</tr>
<tr>
<td align="center">Location:</td>
<td align="center">
<?php 
	while($row=$location->fetch_assoc()) {
		echo $row["city"].", ".$row["state"].", ".$row["country"]." : ".$row["tag"];
		echo "<br>";
	}
?>
</td>
</tr>
<tr>
<td align="center">Qualifications:</td>
<td align ="center">
<?php 
	while($row=$eduQual->fetch_assoc()) {
		echo $row["degree"].", ".$row["field"].", ".$row["institute"];
		echo "<br>";
	}
?>
</td>
</tr>	
<tr>
<td align="center">Work Experience:</td>
<td align ="center">
<?php 
	while($row=$work->fetch_assoc()) {
		echo "<b>".$row["duration"]."</b><br>";
		echo $row["post"].", ".$row["company"];
		echo "<br>";
	}
?>
</td>
</tr>
</table><br>
<form action ="editprofile.php" method ="get">
<input type="submit" value="Edit" >
</form>
<div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
</div>
<?php $link->close(); ?>
</body>
</html>
