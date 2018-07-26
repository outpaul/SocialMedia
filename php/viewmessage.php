<?php

session_start();

require_once "config.php";

$id=$_GET["id"];

$sql = "SELECT firstName,lastName,site FROM socialMedia WHERE accId='$id'";
$ar = $link->query($sql);
$r = $ar->fetch_assoc();

$query = "SELECT * FROM messages WHERE participantId='$id'";
$result = $link->query($query);

$name = $r["firstName"]." ".$r["lastName"];

$userId = $_SESSION["userId"];
$site = $_SESSION["site"];

$my = "SELECT firstName,lastName,site FROM socialMedia WHERE accId=fetchId('$userId','$site')";

$myn = $link->query($my);
$res = $myn->fetch_assoc();
$myname = $res["firstName"]." ".$res["lastName"];

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

	$query = "SELECT * FROM messages WHERE participantId='$id' AND messages.timestamp<='$to' AND messages.timestamp>='$from'";

	$result = $link->query($query);
}

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
	</div><br><br><h1><?php echo $r["site"]; ?> Messages</h1><br><hr><br><br>
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
	<table align="center" width="75%" frame="box">
	<tr bgcolor="silver">
		<th><h2><?php echo $name; ?></h2></th>
		<th><h2><?php echo $myname; ?></h2></th>
	</tr>
	<?php 
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			if($row["msgTag"] == "sent"){
				echo "<td width=\"50%\"></td><td width=\"50%\" bgcolor=\"silver\" align=\"right\">";
				echo $row["content"]."<br>".$row["timestamp"];
			}			
			else if($row["msgTag"] == "received") {
				echo "<td width=\"50%\" bgcolor=\"silver\" align=\"left\">";
				echo $row["content"]."<br>".$row["timestamp"]."</td><td width=\"50%\">";
			}
			echo "</td></tr>";	
		} ?>
	</table>
	<br><br><div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
	</div>
</body>	
</html>
