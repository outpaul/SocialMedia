<?php

session_start();

require_once "config.php";

$userId = $_SESSION["userId"];
$site = $_SESSION["site"];

$query = "SELECT socialMedia.* FROM accFol,socialMedia WHERE accFol.folId=socialMedia.accId AND accFol.accId=fetchId('$userId','$site')";

$result = $link->query($query);

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
		a.style:link, a.style:visited {
			color:black;
			text-decoration: none;
		}
		a.style:hover, a.style:active{
			color:black;
			text-decoration: underline;
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
	
	<?php 
		if($result->num_rows > 0) {
			echo "<h2>Following:</h2><br><br><br>";
			while($row = $result->fetch_assoc()) {
				echo "<a class=\"style\" href=\"viewprofile.php?user=".$row["username"]."\">";
				echo "<table align=\"center\" width=\"100%\" bgcolor=\"silver\">";
				echo "<tr><td width=\"50%\"><img src=\"".$row['media']."\" width=200 height=200></td>";
				echo "<td width=\"50%\"><b>".$row["firstName"]." ".$row["lastName"]."</b><br>".$row["username"]."</td></tr>";
				echo "</table></a><br><br>";
			}
		}
		else {
			echo "<h2>You are not following anyone from this account.</h2>";
		} ?>

	<div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
	<?php $link->close(); ?>
</body>	
</html>
