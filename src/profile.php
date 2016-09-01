<?php
$br = "<br />";
session_start();
if($_SESSION['login'] == 1)
{
	/*
		Need to add this at every page.  If there is no session session_user, then they
		aren't technically logged in, so kick them out.
	*/
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");

	require('header.php');
	require('dbconnect.php');
    require('user_req.php');

	// Grabs all potential information
	$firstname = $user_info['FirstName'];
	$lastname = $user_info['LastName'];
	$email = $user_info['Email'];
	$phone = $user_info['Phone'];
	$age = $user_info['Age'];

	// Then they are at someone else's profile
	if (isset($_GET['user']))
	{
		$get_user = $_GET['user'];
		if ($get_user == $session_user) header("Location: profile.php");
		$query = "SELECT * FROM user_info where Username='$get_user';";
		$result = mysql_query($query);
		$user_info = mysql_fetch_assoc($result);
		echo "At " . $get_user . "'s profile." . $br . $br;
		$email = $user_info['Email'];
		echo "Email: " . $email . $br;

	}

	// Their own profile

	else
	{
		if (isset($_GET['edit']) && $_GET['edit'] == "t")
		{
			if ($phone == "NULL") $phone = "";
			?>
				<form method="POST" action="updateuserinfo.php">
				First Name: <input type="text" name="FirstName" value=<?php echo $firstname;?>><br>
				Last Name: <input type="text" name="LastName" value=<?php echo $lastname;?>><br>
				Phone Number: <input type="text" name="Phone" value=<?php if (is_null($phone)) echo "oeu"; else echo $phone;?>><br>
				Age: <input type="text" name="Age" value=<?php echo $age;?>> <br>
		

				<input type="Submit" name="UpdateProfile" value="Update"/> <br>

				</form>
			<?php
		}
		else
		{
			if ($phone == "NULL") $phone = "";


			echo $firstname . " " . $lastname . "'s profile" . $br . $br;
			?>
				<a href="profile.php?edit=t">Edit Profile</a><br><br>
			<?php
			if (isset($phone)) echo "Phone: " . $phone . $br;
			else echo "Phone: " . $br;	

			echo "Email: " . $email . $br;
			if (isset($age)) echo "Age: " . $age . $br;
			else echo "Age: " . $br;
		}
	}

}
else
{
	// send to login.php?name=profile.php

}
