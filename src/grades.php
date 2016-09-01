<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");

	require('dbconnect.php');
	require('user_req.php');	
	require('header.php');?>
	<br><br><form method="POST" action="study_grades.php">
	<input class="btn" type="submit" name="study" value="Study" />
	</form>
	<form method="POST" action="teach_grades.php">
	<input class="btn" type="submit" name="teach" value="Teach" />
	</form>

<?php
echo $br.$br.$br;
}

else 
{
	echo $_SESSION['login'];
	// send to login page with ?page=home.php so it brings em back here
}

?>
