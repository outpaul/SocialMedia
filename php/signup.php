<?php

require_once 'config.php';

$username=$password=$firstName=$gender="";
$lastName=$dob=NULL;
$username_err=$password_err=$firstName_err=$gender_err=$error="";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$inputf=$_POST["firstName"];

	if(empty($inputf))
		$firstName_err="Please enter a name.<br>";
	else
		$firstName = $inputf;
	
	$inputu=$_POST["user"];

	if(empty($inputu))
		$username_err="Please enter a username.<br>";
	else {
	
		$check = "SELECT userId FROM users WHERE username='$inputu'";
		if($result = $link->query($check)) {
			if($result->num_rows == 1){
				$username_err = "Username already taken.<br>";
			}
			else
				$username = $inputu;
		}
	}

	$inputp=$_POST["pass"];

	if(empty($inputp))
		$password_err = "Please enter a password<br>";
	else
		$password = $inputp;

	$inputg=$_POST["gender"];

	if($inputg == "0")
		$gender_err = "Please select an appropriate gender.<br>";
	else
		$gender = $inputg;

	$lastName=$_POST["lastName"];

	if(empty($firstName_err) || empty($username_err) || empty($password_err) || empty($gender_err)) {
		$query=  "INSERT INTO users(firstName,lastName,username,password,gender) VALUES ('$firstName','$lastName','$username','$password','$gender')";

		if($link->query($query))
			header('location: success.php');
		else
			$error = "Error. Could not create the account.<br>Please try again.";
	}
}

$link->close();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
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

		<h2>Sign Up</h2>
		<p>Please fill this form to create an account</p>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label>Username:<sup>*</sup></label>
			<input type="text" name="user" value="<?php echo $inputu; ?>"><br/>
			<?php echo $username_err ;?><br>

			<label>Password:<sup>*</sup></label>
			<input type="password" name="pass" value=""><br/>
			<?php echo $password_err ;?>

			The password should be between 8 and 32 characters long.<br/><br>

			<label>First Name:<sup>*</sup></label>
			<input type="text" name="firstName" value="<?php echo $inputf; ?>"><br/>
			<?php echo $firstName_err ;?><br>

			<label>Last Name:</label>
			<input type="text" name="lastName" value="<?php echo $lastName; ?>"><br/><br>
			
			<label>Gender:<sup>*</sup></label>
			<select name="gender">
				<option value="0">--SELECT--</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select><br/>
			<?php echo $gender_err ;?><br>
			

		<input type="submit" value="Sign Up"/>
		</form><br><br>
		Already own an account? Login <a href="login.php">here</a>.
		<?php echo $error ;?>
		<div class="footer">
			<hr><i>Virtual Identity Database Project.</i><br><b>Bitan Paul | Mohit Malviya</b>
		</div>
	</body>
</html>
