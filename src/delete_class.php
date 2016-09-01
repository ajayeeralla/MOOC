<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	// This page should only show their classes.  Have a profile page to view their profile.

	/*
		Need to add this at every page.  If there is no session session_user, then they
		aren't technically logged in, so kick them out.
	*/
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");
	

	require('dbconnect.php');
	require('user_req.php');	
	require('header.php');


	$class = $_GET['class'];

	// Get class id
	$class_id = "SELECT class_id FROM classes WHERE class_name='$class';";
	$class_id = mysql_fetch_assoc(mysql_query($class_id));
	$class_id = $class_id['class_id'];

	$delete_query = "DELETE FROM junction_student WHERE Student='$session_user' AND class_id='$class_id';";
	mysql_query($delete_query);

	header("Location: home.php");

}
else
{
	// nothing
}