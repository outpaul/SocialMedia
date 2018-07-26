<?php 

session_start();

require_once "config.php";

$site = $_SESSION["site"];
$userId = $_SESSION["userId"];

$query = "SELECT * FROM socialMedia WHERE accId=fetchId('$userId','$site')";

if($result = $link->query($query)) {
	if($result->num_rows == 0)
		header('location: noaccount.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if($_POST["social"] != "0") {
		$site = $_POST["social"];
		$_SESSION["site"] = $site;
	}
}


$query = "SELECT * FROM socialMedia WHERE accId=fetchId('$userId','$site')";

if($result = $link->query($query)) {
	if($result->num_rows == 0)
		header('location: noaccount.php');
}

$query = "SELECT socialMedia.firstName FROM socialMedia,userAcc WHERE socialMedia.accId=userAcc.accId AND socialMedia.site='$site' AND userAcc.userId='$userId'";

$result = $link->query($query);
$r = $result->fetch_assoc();

$accName = $r['firstName'];

$link->close();

?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $site; ?></title>
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
		Hi <?php echo $accName; ?>!<br>
		View your profile <a href="accprofile.php">here</a>.
		<br><hr><br><br>
		<a href="followers.php">Followers</a>&nbsp&nbsp&nbsp&nbsp
		<a href="following.php">Following</a><br><br>
		Also view:<br><br>
		<table width="100%" border=0>
			<tr>
				<th width="50%" bgcolor="yellow"><a href="post.php">Posts</a></th>
				<th width="50%" bgcolor="yellow"><a href="message.php">Messages</a></th>
			</tr>
		</table>

		<br><br><br>
		<form action="deleteacc.php" method="get">
			<input type="submit" value="Delete Account">
		</form>
		<div class="footer">
		<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
		</div>
	</body>
</html>
