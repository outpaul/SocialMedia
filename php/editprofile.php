<?php

session_start();

require_once 'config.php';

$userId=$_SESSION["userId"];
$originaluser = $_SESSION["username"];

$shashank = "SELECT * FROM work WHERE userId='$userId'";
$work = $link->query($shashank);
$shashank = "SELECT * FROM location WHERE userId='$userId'";
$location = $link->query($shashank);
$shashank = "SELECT * FROM eduQual WHERE userId='$userId'";
$edu = $link->query($shashank);

$username=$password=$firstName=$gender="";
$lastName=$dob=NULL;
$username_err=$password_err=$firstName_err=$gender_err=$error="";

$result=$link->query("SELECT * from users WHERE userId='$userId'");
$extract=$result->fetch_assoc();
$bio = $extract['bio'];
if(!empty($_SESSION["bio"]))
	$bio = $_SESSION['bio'];

if($_SERVER["REQUEST_METHOD"] == "POST") {

		$folder = "images";
		$pname =$_FILES["pic"]["name"];

		if(!empty($pname)) { 
			$pic = $folder."/".$pname;
			move_uploaded_file($_FILES["pic"]["tmp_name"],$pic);
		}
		else
			$pic = $extract['image'];
	

		$inputf=$_POST["firstName"];

		if(empty($inputf))
			$firstName_err="Please enter a name.";
		else
			$firstName = $inputf;
	
		$inputu=$_POST["username"];

		if(empty($inputu))
			$username_err="Please enter a username.";
		else {
	
			$check = "SELECT * FROM users WHERE username='$inputu'";
			if($result = $link->query($check)) {
				if($result->num_rows == 1 && $inputu != $originaluser){
					$username_err = "Username already exists.";
				}
				else
					$username = $inputu;
			}
		}

		$inputp=$_POST["password"];

		if(empty($inputp))
			$password_err = "Please enter a password.";
		else
			$password = $inputp;

		$inputg=$_POST["gender"];

		if($inputg == "0")
			$gender_err = "Please select an appropriate gender.";
		else
			$gender = $inputg;

		$lastName=$_POST["lastName"];
		$duration=$_POST["exp"];
		$post=$_POST["post"];
		$company=$_POST["company"];
		$tag=$_POST["tag"];
		$city=$_POST["city"];
		$state=$_POST["state"];
		$country=$_POST["country"]; 
		$degree=$_POST["degree"];
		$field=$_POST["field"];
		$institute=$_POST["institute"];
		$rawdate = htmlentities($_POST['dob']);
		$date = date('Y-m-d', strtotime($rawdate));
		$contact=$_POST["contact"];
		$email=$_POST["email"];

		if(empty($contact))
			$contact = extract['contact'];
		if(empty($email))
			$email = extract['email'];
		if(empty($dob))
			$dob = extract['dob'];

		if(empty($firstName_err) && empty($username_err) && empty($password_err) && empty($gender_err)) {
			$query=  "UPDATE users SET firstName='$firstName',lastName='$lastName',username='$username',password='$password',gender='$gender',image='$pic',contact='$contact',dob='$date',email='$email' WHERE userId='$userId'";

			if($link->query($query)) {
				header('location: editsuccess.php');
				$_SESSION["username"] = $username;
				$_SESSION["name"] = $firstName;
				if(!empty($duration) || !empty($post) || !empty($company)) {
					$query = "INSERT INTO work VALUES ('$userId','$duration','$post','$company')";
					$link->query($query);
				}
				if(!empty($city) || !empty($state) || !empty($country)) {
					$query = "CALL location('$userId','$tag','$city','$state','$country')";
					$link->query($query);
				}
				if(!empty($degree) || !empty($field) || !empty($institute)) {
					$query = "INSERT INTO eduQual VALUES ('$userId','$degree','$field','$institute')";
					$link->query($query);		
				}
			}
			else
				$error="Something went wrong. Please try again.";
		}
}



?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit Profile Page</title>
		<style>
			.footer {
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
		</div>
		<br>
		<h1>Edit Profile</h1><br><hr><br>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

			<label>Image: </label>
			<input type="file" name="pic"><br><br>

			<label>Username<sup>*</sup>:</label><br>
			<input type="text" name="username" value="<?php echo $extract["username"]; ?>" ><br/>
			<?php echo $username_err; ?><br><br>

			<label>First Name<sup>*</sup>:</label><br>
			<input type="text" name="firstName" value="<?php echo $extract["firstName"]; ?>" ><br/>
			<?php echo $firstName_err; ?><br><br>

			<label>Last Name:</label> <br>
			<input type="text" name="lastName" value="<?php echo $extract["lastName"]; ?>" ><br/><br>

			<label>Password<sup>*</sup>:</label><br>
						<input type="password" name="password" value=""><br/>
						<?php echo $password_err; ?><br><br>

						The password should be less than 32 characters long.<br/><br>


			<label>Gender<sup>*</sup>:</label> <br><br>
			<select name="gender">
				<option value="0">--SELECT--</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
				</select><br/>
			<?php echo $gender_err; ?><br><br>
			<label>Bio:</label><br>
			<input type="text" name="bio" value="<?php echo $bio; ?>"><br>
			Fetch from: <a href="process.php?social=Faceboook">Facebook</a>&nbsp&nbsp<a href="process.php?social=Instagram">Instagram</a>&nbsp&nbsp<a href="process.php?social=Twitter">Twitter</a>&nbsp&nbsp<a href="process.php?social=Google">Google +</a>&nbsp&nbsp<br><br>
			<label>Date of Birth:</label<br>
			<input type="date" name="dob" value="<?php echo $extract["dob"]; ?>"><br><br>

			<label>Contact:</label><br>
			<input type="text" name="contact" value="<?php echo $extract["contact"]; ?>"><br><br>

			<label>E-mail:</label><br>
			<input type="text" name="email" value="<?php echo $extract["email"]; ?>"><br><br>
			<b>Work</b>			
			<table align="center" frame="box">
			<?php 
				while($row=$work->fetch_assoc()) {
							echo "<tr><td>";
							echo $row["duration"]." - ".$row["post"].", ".$row["company"];
							echo "</td></tr>";
				}				
			?>
			<tr><td width="50%">Experience: </td>
			<td>
			<input type="text" name="exp" value=""></td></tr>
			<tr><td width="50%">Post: </td>
			<td><input type="text" name="post" value=""></td></tr>
			<tr><td width="50%">Company: </td>
			<td><input type="text" name="company" value=""></td></tr>
			</table><br><br>
			<b>Qualifications</b>			
			<table align="center" frame="box">
			<?php 
				while($row=$edu->fetch_assoc()) {
							echo "<tr><td>";
							echo $row["degree"].", ".$row["field"].", ".$row["institute"];
							echo "</td></tr>";
				}				
			?>
			<tr><td width="50%">Degree: </td>
			<td>
			<input type="text" name="degree" value=""></td></tr>
			<tr><td width="50%">Field: </td>
			<td><input type="text" name="field" value=""></td></tr>
			<tr><td width="50%">Institute: </td>
			<td><input type="text" name="institute" value=""></td></tr>
			</table><br><br>
			<b>Location</b>			
			<table align="center" frame="box">
			<?php 
				while($row=$location->fetch_assoc()) {
							echo "<tr><td>";
							echo $row["city"].", ".$row["state"].", ".$row["country"]." : ".$row["tag"];
							echo "</td></tr>";
				}				
			?>
			<tr><td>
			<input type="radio" name="tag" value="current" checked>Current</td>
			<td><input type="radio" name="tag" value="lived">Lived</td></tr>
			<tr><td width="50%">City: </td>
			<td>
			<input type="text" name="city" value=""></td></tr>
			<tr><td width="50%">State: </td>
			<td><input type="text" name="state" value=""></td></tr>
			<tr><td width="50%">Country: </td>
			<td><input type="text" name="country" value=""></td></tr>
			</table><br><br>
			<input type="submit" value="Save Changes">
		</form><br><br>
		<form action="dashboard.php">
			<input type="submit" value="  Discard  " >
		</form><br><br>
		<?php echo $error; 
			$link->close(); ?>
		<div class="footer">
			<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
		</div>
	</body>
</html>
