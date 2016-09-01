<?php /*
session_start();
if (isset($_SESSION['login']))
{
	if ($_SESSION['login'] == 1)
	{
		//echo $_SESSION['login'];
		session_write_close();
		header("Location: home.php");
	}
}*/
?>
<html>

<head>
<link rel="stylesheet" type="text/css" href="cssproperties.css">
</head>
<div id="header">
	<!-- Add in code for a nav bar and put in new logo -->
   		<div id="logo">
    	<!-- This is just a blank link now, this link should be changed to go to our imediate home page or if when the person is logged in their homepage -->
        <!-- Later versions of this header will include (logout/login links, search bar, etc. )-->
    	<a href = "#" ><img src="images/MoocLogo.png" height = "75px" width:"auto"/></a>
        </div>
        <div id="socialNav">
       		<h3>"The future of online learning"</h3>
        </div>
</div>
<body>
<div id="Register">
<h3> Register Here </h3> <br>
<form method="POST" action="register.php">
<!--First Name <input type="text" name="FirstName" required/> <br>
Last Name <input type="text" name="LastName" required/> <br>-->
Email <input type="text" name="Email" required/> <br>
Username <input type="text" name="Username" required/> <br>
Password <input type="password" name="Password" required/> <br>
Confirm Password <input type="password" name="Password" required/> <br>
<!-- Student <input type="radio" name="sOp" id="Student"/>
Professor <input type="radio" name="sOp" id="Professor"/><br>-->
<input type="submit" name="register" value="Register"/>
</form>
</div>
<div id="Loggin">
<h3> Login Here </h3>

<form method="POST" action="index.php">
Username <input type="text" name="Username" required/> <br>
Password <input type="password" name="Password" required/> <br>
<input type="Submit" name="Login" value="Login"/>
</form>
</div>
</body>
</html>

<?php

if(isset($_POST['Login']))
{
	require('dbconnect.php');

	$session_user = $_POST['Username'];
	$password = $_POST['Password'];

	$salt1    = "hn2h7e3k";
	$salt2    = "u3en9e";
	$password = $salt1 . hash('ripemd160', $password) . $salt2;

	$auth_query   = "SELECT Username, Password FROM users WHERE Username='$session_user' AND Password='$password';";
	$result_query = mysql_query($auth_query);
	
	// Found a row with matching session_user and password
	if (mysql_num_rows($result_query) == 1)
	{
		// These four are from the users table containing only their session_user and password
		$user_query = "SELECT * FROM users where Username='$session_user'";
		$user_result = mysql_query($user_query);
		$user_creds = mysql_fetch_assoc($user_result);
		$session_user = $user_creds['Username'];

		// This selects from the user_info table to see if they set their names after registration
		$user_info_query = "SELECT * FROM user_info WHERE Username='$session_user';";
		$user_info_result = mysql_query($user_info_query);
		$user_info = mysql_fetch_assoc($user_info_result);

		$firstname = $user_info['FirstName'];
		$lastname  = $user_info['LastName'];

		if(isset($firstname))
		{
			session_start();
			$_SESSION['login']     = 1;
			$_SESSION['session_user']  = $session_user;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname']  = $lastname;
			session_write_close();
			header("Location: home.php");	
		}
		else
		{
			/*  This means that when they confirmed by email they exited out of the page
				that had them enter in their first and last name.  Send them to do that.
			*/
				header("Location: first.php?t=n");
		}

	}
	else
	{
		?>
		<error> Wrong session_user or password.</error>
		<?php
	}



}


?>
