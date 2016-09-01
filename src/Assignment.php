<?php
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');	
	require('header.php');

	echo $br . $br . "Assignments ".$br . $br; ?> 
	<a href="createassignment.php">Create new</a><br><br>
	
   <!---<a href="logout.php">Logout</a>--->
	<?php
}

else 
{
	// send to login page with ?page=home.php so it brings em back here
}

?>
