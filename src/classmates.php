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
	
	require('header.php');
	require('dbconnect.php');
	require('user_req.php');	

	$class_query = "SELECT class_id FROM junction_student WHERE Student='$session_user';";
	$class_query_results = mysql_query($class_query);
	while ($row = mysql_fetch_assoc($class_query_results))
	{
		$class_id = $row['class_id'];
		$class_query_2 = "SELECT * FROM classes WHERE class_id='$class_id'";
		$class_query_results_2 = mysql_query($class_query_2); 
		while ($class_name = mysql_fetch_assoc($class_query_results_2))
		{
			echo "Class: " . $class_name['class_name'] . $br;	
			$classmates_query = "SELECT Student FROM junction_student WHERE class_id='$class_id';";
			$classmates_query_results = mysql_query($classmates_query);
			while($classmate_name = mysql_fetch_assoc($classmates_query_results))
			{
				$classmate_name = $classmate_name['Student'];
				if ($classmate_name != $session_user) echo "<a href='profile.php?user=$classmate_name'>$classmate_name</a>" . $br;
			}
			echo $br;
		}
		
	}


}
else
{
	//header page=classmates.php
}