<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');

	$username = $_POST['student'];
	$grade = $_POST['input_grade'];
	$class_id = $_POST['class_id'];
	$fileid = $_POST['fileid'];

	// First check if there is an existing grade.  If so, delete it
	$grade_check = "SELECT COUNT(*) rcount FROM grades WHERE class_id='$class_id' AND file_id='$fileid';";
	$grade_check = mysql_fetch_assoc(mysql_query($grade_check));
	$grade_check = $grade_check['rcount'];

	// So there's already a grade in there, delete it
	if ($grade_check != 0)
	{
		echo "in the if" . $br;
		$update_query = "UPDATE grades SET grade='$grade' WHERE file_id='$fileid';";
		mysql_query($update_query);
		echo $update_query;
		header("Location: submissions.php?classid=$class_id");
	}
	else
	{
		echo "in the else";
		$query = "INSERT INTO grades (class_id, file_id, grade) VALUES('$class_id', '$fileid', '$grade');";		
		mysql_query($query);
		header("Location: submissions.php?classid=$class_id");
	}
}
