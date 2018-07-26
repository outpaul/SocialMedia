<?php

session_start();

$userId = $_SESSION["userId"];
$site = $_SESSION["site"];

require_once "config.php";

$query = "SELECT socialMedia.firstName FROM socialMedia,userAcc WHERE socialMedia.accId=userAcc.accId AND socialMedia.site='$site' AND userAcc.userId='$userId'";

$result = $link->query($query);
$r = $result->fetch_assoc();

$accName = $r['firstName'];

$query = "SELECT DISTINCT messages.participantId FROM messages,socialMedia,accMsg WHERE messages.msgId=accMsg.msgId AND socialMedia.accId=accMsg.accId AND socialMedia.accId=fetchId('$userId','$site')";

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

	$query = "SELECT DISTINCT messages.participantId FROM messages,socialMedia,accMsg WHERE messages.msgId=accMsg.msgId AND socialMedia.accId=accMsg.accId AND socialMedia.accId=fetchId('$userId','$site') AND messages.timestamp<='$to' AND messages.timestamp>='$from'";

	$result = $link->query($query);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		.footer {
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
	</style>
</head>
<body align="center">
	<div align="right">
		<a href="dashboard.php">Dashboard</a><em>|</em><a href="logout.php">Logout</a><br><hr>
	</div><br><br>
	<h2><?php echo $site; ?></h2><br><hr>
	<h3><?php echo $accName; ?>'s Messages</h3><br><br>
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
					$id = $row["participantId"];
					$sql = "SELECT firstName,lastName FROM socialMedia WHERE accId='$id'";
					$ar = $link->query($sql);
					$r = $ar->fetch_assoc();
					echo "<table align=\"center\" width=\"50%\" border=0 bgcolor=\"silver\">";
					echo "<tr>";
						echo "<th><a class=\"style\" href=\"viewmessage.php?id=".$id."\">".$r["firstName"]." ".$r["lastName"]."</a></th>";
					echo "</tr>";
					echo "</table>";
					echo "<br><br>";
				}
		}
		else
			echo "<h2>No messages available in this account</h2>";	
	$link->close();
	?>
	<br><br><div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
