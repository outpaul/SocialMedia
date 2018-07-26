<?php

session_start();

$userId = $_SESSION["searchuid"];
$site = $_SESSION["searchSite"];

require_once "config.php";

$query = "SELECT fetchName('$site','$userId') as firstName";

$result = $link->query($query);
$r = $result->fetch_assoc();

$accName = $r['firstName'];

$query = "SELECT posts.* FROM posts,socialMedia,accPost WHERE posts.postId=accPost.postId AND socialMedia.accId=accPost.accId AND socialMedia.accId=fetchId('$userId','$site')";

$result = $link->query($query);

$date = "SELECT CURDATE() as now";
$r = $link->query($date);
$tod = $r->fetch_assoc();
$todate = $tod['now'];
$time = "SELECT CURTIME() as now";
$r = $link->query($time);
$tot = $r->fetch_assoc();
$totime = $tot['now'];
$fromdate = '0000-01-01';
$fromtime = '00:00:00';

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$fromdate = htmlentities($_POST['fromdate']);

	$fromtime = htmlentities($_POST['fromtime']);

	$todate = htmlentities($_POST['todate']);

	$totime = htmlentities($_POST['totime']);

	$from = date('Y-m-d H:i:s', strtotime("$fromdate $fromtime"));
	$to = date('Y-m-d H:i:s', strtotime("$todate $totime"));

	$query = "SELECT posts.* FROM posts,socialMedia,accPost WHERE posts.postId=accPost.postId AND socialMedia.accId=accPost.accId AND socialMedia.accId=fetchId('$userId','$site') AND posts.timestamp<='$to' AND posts.timestamp>='$from'";
	$result = $link->query($query);
}


$link->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $accName; ?>'s<?php echo $site; ?> Posts</title>
	<style>
		.footer {
		    position: fixed;
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
	<h2><?php echo $site; ?></h2><br><hr>
	<h3><?php echo $accName; ?>'s Posts</h3><br><br>
	<div align="right">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label>From:</label>
			<input type="text" name="fromdate" value="<?php echo $fromdate; ?>">&nbsp
			<input type="text" name="fromtime" value="<?php echo $fromtime; ?>">&nbsp&nbsp
			<label>To:</label>
			<input type="text" name="todate" value="<?php echo $todate; ?>">&nbsp
			<input type="text" name="totime" value="<?php echo $totime; ?>">&nbsp
			<input type="submit" value="Go">
		</form>	
	</div><br><br>
	<?php 
		if($result->num_rows > 0) {

				while($row = $result->fetch_assoc()) {
					echo "<table width=\"100%\" border=0 bgcolor=\"silver\">";
					echo "<tr>";
						echo "<td><b>Time:</b> ".$row['timestamp']."</td>";
						echo "<td></td>";
						echo "<td><b>Location:</b> ".$row['location']."</td>";
					echo "</tr>";
					echo "<tr>";
						if($row['media'] != NULL)
							echo "<td><img src=\"".$row['media']."\" width=200 height=200></td>";
						else
							echo "<td></td>";
						echo "<td><b>Status:</b> ".$row['text']."</td>";
						echo "<td>"."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td><b>Likes:</b> ".$row['likes']."</td>";
						echo "<td><b>Comments:</b> ".$row['comments']."</td>";
						echo "<td><b>Shares:</b> ".$row['shares']."</td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><br>";
				}
		}
		else
			echo "<h2>No posts available in this account</h2>";	
	?>

	<br><br><div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
