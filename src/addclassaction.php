<?php
$br = "<br />";
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');

	if (isset($_GET['class']))
	{	

		?>
		<a href="home.php">Home</a><br><br>
		<?php
		$class = $_GET['class'];
		// get that classes id
		$query = "SELECT class_id FROM classes WHERE class_name='$class';";
		$result = mysql_query($query);
		$class_id = mysql_fetch_assoc($result);
		//echo "Class id: " . $class_id['class_id'];

		$enter_class_id = $class_id['class_id'];

		// First check if they are already in that class.
		$check_query = "SELECT * FROM junction_student WHERE Student='$session_user' AND class_id='$enter_class_id'";
		$result_check = mysql_query($check_query);
		$rows = mysql_num_rows($result_check);

		if ($rows == 0)
		{
			$professor_query = "SELECT professor FROM classes WHERE class_id='$enter_class_id';";
			$professor_query_results = mysql_query($professor_query);
			$professor = mysql_fetch_assoc($professor_query_results);
			$professor = $professor['professor'];

			$professor_name_query = "SELECT * FROM user_info WHERE Username='$professor';";
			$professor_name_results = mysql_query($professor_name_query);
			$professor_name = mysql_fetch_assoc($professor_name_results);
			$professor_first_name = $professor_name['FirstName'];
			$professor_last_name = $professor_name['LastName'];
			$professor_email = $professor_name['Email'];

			$number_students_query = "SELECT COUNT(*) rcount FROM junction_student WHERE class_id='$enter_class_id';";
			$nuber_students_result = mysql_query($number_students_query);
			$number_students = mysql_fetch_assoc($nuber_students_result);
			$number_students = $number_students['rcount'];

			$firstname = $user_info['FirstName'];
			$lastname = $user_info['LastName'];

			$url = "http://oscar.zapto.org/CS350/cryptobionic/fabbricm/managestudents.php?class=$class&user=$session_user";
			$url = $new = str_replace(' ', '%20', $url);

			$rand_num = rand(1, 1000);


			// So they aren't in that class, now email the professor so they can approve them, and put them in the temp_classes table.
			$message = "$firstname $lastname wants to join your class.  The current number of students in your class is $number_students. Click the link below to admit the student into your class. The authentication key for this user is $rand_num ";
			$message = " " . $message . "$url";
			$sendmail = "echo '$message' | mailx -s 'Register' '$professor_email'";
			shell_exec($sendmail);

			echo "Email sent to the professor.";

			// insert them into the temp class table and email the professor
			$temp_query = "INSERT INTO temp_class (class_id, username, professor, rand_key) VALUES('$enter_class_id', '$session_user', '$professor', '$rand_num');";
			mysql_query($temp_query);
		}
		else
		{
			echo "You are already in that class!";
			// possibly redirect them to that class page.
		}
	}
	else
	{
		header("Location: home.php");
	}
}

?>
