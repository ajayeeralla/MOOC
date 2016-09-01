<html>
<head><link rel="stylesheet" type="text/css" href="cssproperties.css"></head>
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
        <ul id="globalNavBar">
        </ul>  
</div>
<body>

</body>
</html>

<?php
$br = "<br />";
if(isset($_POST['register']))
{
	require('dbconnect.php');

	//echo "Register button works.";
	//$firstname = $_POST['FirstName'];
	//$lastname  = $_POST['LastName'];
	$email     = $_POST['Email'];
	$session_user  = $_POST['Username'];
	$password  = $_POST['Password'];

	$key      = md5($session_user);
	$rand_num = rand(1, 1000);
	$key      = $key . $rand_num;

	$salt1 = "hn2h7e3k";
	$salt2 = "u3en9e";
	
	//echo "email: " . $email . $br;
	//echo "session_user: " . $session_user . $br;
	//echo "key: " . $key . "<br />";
	//echo "rand_num: " . $rand_num . $br;
	$password = $salt1 . hash('ripemd160', $password) . $salt2;
	//echo $email . $br;
	//echo $session_user . $br;

	?>
	<p> Thanks for registering! Now check you email for the confirmation link.</p>
	<?php

	$val = mysql_query('select * from temp_users');
	if ($val == FALSE) {
		mysql_query("CREATE TABLE temp_users(Email VARCHAR(100),Username VARCHAR(100), Password VARCHAR(100), auth_key VARCHAR(100))");
	}
	$query = "INSERT INTO temp_users(Email, Username, Password, auth_key) VALUES ('$email', '$session_user', '$password', '$key'); ";
//	echo $query;
	mysql_query($query);
	$message = "Thanks for signing up for mooc! To confirm your registration, please click the link below. ";

	//$message = $message . "http://oscar.zapto.org/CS350/cryptobionic/fabbricm/add.php?u=$session_user&k=$key";
	$message = $message . "http://oscar.zapto.org/CS350/cryptobionic/fabbricm/add.php?u=$session_user&k=$key";

//$message = $message . "http://localhost/src/add.php?u=$session_user&k=$key";
// it is working with me---ajay5251
//$message = wordwrap($message, 70, "\r\n");
//mail($email, 'Confirmation', $message);
	$sendmail = "echo '$message' | mailx -s 'Confirmation' '$email'";

	shell_exec($sendmail);
}
else 
{
	echo "no";
}

?>
