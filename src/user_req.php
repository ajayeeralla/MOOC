<?php
	$br = "<br />";
	// stops the stupid time error.
	date_default_timezone_set('UTC');
	#if ($_SESSION['login'] ==  null) header("Location: logout.php");
	#if (is_null($_SESSION['login'] header("Location: index.php");
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");
	$session_user = $_SESSION['session_user'];
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	
	$query = "SELECT * FROM user_info where Username='$session_user';";
   $result = mysql_query($query);
   $user_info = mysql_fetch_assoc($result);

?>
