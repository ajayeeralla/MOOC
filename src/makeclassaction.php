<head><link rel="stylesheet" type="text/css" href="HomeStyle.css"></head>

<?php
$br = "<br />";
session_start();
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

//	$session_user = $_SESSION['session_user'];

	if (isset($_POST['makeclass']))
	{	
		$val = mysql_query('select * from classes');
		if ($val == FALSE) {
			mysql_query("CREATE table classes (class_id int NOT NULL AUTO_INCREMENT, class_name varchar(100), professor varchar(100), primary key(class_id));");
		}
		
		// First check if the total was 100 before doing anything else

		$test     = (float)$_POST['Test'];
		$quiz     = (float)$_POST['Quiz'];
		$homework = (float)$_POST['Homework'];
		$project  = (float)$_POST['Project'];

		$sum = $test+$quiz+$homework+$project;

		if ($sum != 100)
		{
			echo "Your weights did not add up to 100.  Please go back and enter them again.";
		}
		else
		{
			$classname = $_POST['classname'];
			$query = "INSERT INTO classes (class_id, class_name, professor) VALUES ('', '$classname', '$session_user');";
			mysql_query($query);
			
			/* 
				Because the class_id is incremented each time, and the weights don't match up with the class_id, we have to first insert
			   	the class into the classes table, then grab the class_id that it was given.
			*/
			$class_id_query = "SELECT class_id FROM classes WHERE class_name='$classname';";
			$class_id_query = mysql_fetch_assoc(mysql_query($class_id_query));
			$class_id = $class_id_query['class_id'];

			$weight_query = "INSERT INTO weights (class_id, Test, Quiz, Homework, Project, Total) VALUES('$class_id', '$test', '$quiz', '$homework', '$project', '$sum');";
			mysql_query($weight_query);

			echo "Class " . $classname . " created!" . $br . $br;
			?> <a href="home.php">Home</a><?php
		}
	}
	else
	{
		header("Location: home.php");
	}
}
else
{
	// login.php
}

