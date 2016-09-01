<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');

	if(isset($_POST['add'])) 
	{
		$student = $_POST['student'];
		$key = $_POST['key'];
		
		// Now check the sql table for matching student in key with class 

		// Find the student in the temp_class table
		$find_student_query = "SELECT * FROM temp_class WHERE username='$student' AND rand_key='$key';";
		$find_student = mysql_query($find_student_query);
		
		if (($find_student_results = mysql_num_rows($find_student)) > 0)
		{
			// Now with class id, find the class
			$find_student_results = mysql_fetch_assoc($find_student);
			$class_id = $find_student_results['class_id'];

			$class_name_query = "SELECT class_name FROM classes WHERE class_id='$class_id';";
			$class_name_results = mysql_fetch_assoc(mysql_query($class_name_query));
			$class_name = $class_name_results['class_name'];

			//echo "$student was added to $class_name";
			
			// Get email from student
			$student_query = "SELECT Email FROM user_info WHERE username='$student';";
			$student_query = mysql_fetch_assoc(mysql_query($student_query));
			$email = $student_query['Email'];

			$message = "You have been admitted into $class_name.";
			$send_mail = "echo '$message' | mailx -s 'Class' '$email'";
			
			shell_exec($send_mail);

			$add_query = "INSERT INTO junction_student (Student, class_id) VALUES('$student', '$class_id');";

			mysql_query($add_query);

			header("Location: managestudents.php?class=$class_name");
			
		}



	}
	else echo "no";

}
else
{
	//login.php
}
