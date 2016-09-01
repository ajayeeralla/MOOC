<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');
	echo $br;
	if(isset($_GET['classid']))
	{


		$class_id=$_GET['classid'];
		
		//create the grades table if it does not exist
		$val = mysql_query('select * from grades');
		if ($val == FALSE) {
			mysql_query("CREATE TABLE grades(class_id varchar(20), file_id int(11), grade int);");
		}
		$grades_query = "SELECT grades.file_id, submissions.username, submissions.assignment_id, submissions.filename, grades.grade from grades INNER JOIN submissions ON grades.file_id=submissions.file_id WHERE submissions.username='$session_user' and grades.class_id='$class_id';
		";
		
		$results = mysql_query($grades_query);
echo "<h3> " . $session_user . "'s  Grades </h3>";
echo "<table style='left-padding=' border='1' cellpadding='7'>".$br;?>
<tr>
<!--<th>File ID</th>-->
<!-- <th>Username</th> -->
<th>Assignment</th>
<th>Filename</th>
<th>Grade</th>
</tr><?php
	while($row = mysql_fetch_array($results))
	{
		$fileid=$row['file_id'];
		//$username=mysql_fetch_row(mysql_query("select username from submissions where file_id=$fileid;"))[0];
		$username=$row['username'];
		$assignment_name = mysql_fetch_row(mysql_query("select filename from files where file_id=$row[assignment_id];"))[0];
		//$filename = mysql_fetch_row(mysql_query("select filename from files where file_id=$fileid;"))[0];
		$filename=$row['filename'];
		$grade=$row['grade'];
		echo "<tr>";
		//echo "<td>" . $fileid . "</td>";
		//echo "<td>" . $username . "</td>";
		echo "<td>" . '<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/' .$assignment_name . '">' .$assignment_name. '</a>' . "</td>";
		echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
		echo "<td>" . $grade . "</td>";

		echo "</tr>";
		
	}
	echo "</table>".$br.$br.$br;

	// Now add up their grades

	/*
		So first we have to have a while loop that goes through all the student's hw, then tests, etc.
	*/

	// Homework
	$homework_array=array("");
	$homework_query = "SELECT submissions.file_id FROM assignments INNER JOIN submissions ON submissions.assignment_id=assignments.file_id WHERE assignments.assignment_type='Homework' AND submissions.username='$session_user';";
	$homework_query = mysql_query($homework_query);
	$i=0;
	while($homework_row = mysql_fetch_assoc($homework_query))
	{
		$homework_id = $homework_row['file_id'];
		// Now get the grades
		
		$homework_grade_query = "SELECT grade from grades WHERE file_id='$homework_id';";
		$homework_grade = mysql_fetch_assoc(mysql_query($homework_grade_query));
		$homework_grade = $homework_grade['grade'];
		

		$homework_array[$i] = $homework_grade;
		$i++;
		// Now that everything is in the array, add it all up and average it out, then multiply by the weight/100
	}

		// Find out the weight of the homework
		$sum = 0;
		$h=0;
		for($h; $h<count($homework_array); $h++)
		{
			$sum = $sum + $homework_array[$h];
		}

		$sum = $sum/count($homework_array);

		$homework_weight = "SELECT Homework FROM weights WHERE class_id='$class_id';";
		$homework_weight = mysql_fetch_assoc(mysql_query($homework_weight));
		$homework_weight = $homework_weight['Homework'];
		$homework_weight = (float)$homework_weight;
		$homework_weight = $homework_weight/100;
		$homework_sum = $sum;
		$homework_grade = $sum*$homework_weight;

		//echo "Final homework grade is " . $homework_grade . $br;

		$f_homework = $homework_grade;


		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	// Quiz
	$homework_array=array("");
	$homework_query = "SELECT submissions.file_id FROM assignments INNER JOIN submissions ON submissions.assignment_id=assignments.file_id WHERE assignments.assignment_type='Quiz' AND submissions.username='$session_user';";
	$homework_query = mysql_query($homework_query);
	$i=0;
	while($homework_row = mysql_fetch_assoc($homework_query))
	{
		$homework_id = $homework_row['file_id'];
		// Now get the grades
		
		$homework_grade_query = "SELECT grade from grades WHERE file_id='$homework_id';";
		$homework_grade = mysql_fetch_assoc(mysql_query($homework_grade_query));
		$homework_grade = $homework_grade['grade'];
		

		$homework_array[$i] = $homework_grade;
		$i++;
		// Now that everything is in the array, add it all up and average it out, then multiply by the weight/100
	}

		// Find out the weight of the homework
		$sum = 0;
		$h=0;
		for($h; $h<count($homework_array); $h++)
		{
			$sum = $sum + $homework_array[$h];
		}

		$sum = $sum/count($homework_array);

		$homework_weight = "SELECT Quiz FROM weights WHERE class_id='$class_id';";
		$homework_weight = mysql_fetch_assoc(mysql_query($homework_weight));
		$homework_weight = $homework_weight['Quiz'];
		$homework_weight = (float)$homework_weight;
		$homework_weight = $homework_weight/100;
		$quiz_sum = $sum;
		$homework_grade = $sum*$homework_weight;

		//echo "Final quiz grade is " . $homework_grade . $br;

		$f_quiz = $homework_grade;

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	// Test
	$homework_array=array("");
	$homework_query = "SELECT submissions.file_id FROM assignments INNER JOIN submissions ON submissions.assignment_id=assignments.file_id WHERE assignments.assignment_type='Test' AND submissions.username='$session_user';";
	$homework_query = mysql_query($homework_query);
	$i=0;
	while($homework_row = mysql_fetch_assoc($homework_query))
	{
		$homework_id = $homework_row['file_id'];
		// Now get the grades
		
		$homework_grade_query = "SELECT grade from grades WHERE file_id='$homework_id';";
		$homework_grade = mysql_fetch_assoc(mysql_query($homework_grade_query));
		$homework_grade = $homework_grade['grade'];
		

		$homework_array[$i] = $homework_grade;
		$i++;
		// Now that everything is in the array, add it all up and average it out, then multiply by the weight/100
	}

		// Find out the weight of the homework
		$sum = 0;
		$h=0;
		for($h; $h<count($homework_array); $h++)
		{
			$sum = $sum + $homework_array[$h];
		}

		$sum = $sum/count($homework_array);

		$homework_weight = "SELECT Test FROM weights WHERE class_id='$class_id';";
		$homework_weight = mysql_fetch_assoc(mysql_query($homework_weight));
		$homework_weight = $homework_weight['Test'];
		$homework_weight = (float)$homework_weight;
		$homework_weight = $homework_weight/100;
		$test_sum = $sum;
		$homework_grade = $sum*$homework_weight;

		//echo "Final test grade is " . $homework_grade . $br;	

		$f_test = $homework_grade;

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Project
	$homework_array=array("");
	$homework_query = "SELECT submissions.file_id FROM assignments INNER JOIN submissions ON submissions.assignment_id=assignments.file_id WHERE assignments.assignment_type='Project' AND submissions.username='$session_user';";
	$homework_query = mysql_query($homework_query);
	$i=0;
	while($homework_row = mysql_fetch_assoc($homework_query))
	{
		$homework_id = $homework_row['file_id'];
		// Now get the grades
		
		$homework_grade_query = "SELECT grade from grades WHERE file_id='$homework_id';";
		$homework_grade = mysql_fetch_assoc(mysql_query($homework_grade_query));
		$homework_grade = $homework_grade['grade'];
		

		$homework_array[$i] = $homework_grade;
		$i++;
		// Now that everything is in the array, add it all up and average it out, then multiply by the weight/100
	}

		// Find out the weight of the homework
		$sum = 0;
		$h=0;
		for($h; $h<count($homework_array); $h++)
		{
			$sum = $sum + $homework_array[$h];
		}

		$sum = $sum/count($homework_array);

		$homework_weight = "SELECT Project FROM weights WHERE class_id='$class_id';";
		$homework_weight = mysql_fetch_assoc(mysql_query($homework_weight));
		$homework_weight = $homework_weight['Project'];
		$homework_weight = (float)$homework_weight;
		$homework_weight = $homework_weight/100;
		$homework_grade = $sum*$homework_weight;
		$project_sum = $sum;
		$f_project = $homework_grade;

		$final_grade = $f_homework + $f_quiz + $f_test + $f_project;

		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$final_grade_check = "SELECT COUNT(*) rcount FROM final_grades WHERE username='$session_user' AND class_id='$class_id';";
		$final_grade_check = mysql_fetch_assoc(mysql_query($final_grade_check));
		$final_grade_check = $final_grade_check['rcount'];

		if ($final_grade_check == 0)
		{
			$final_grade_query = "INSERT INTO final_grades (username, class_id, grade) VALUES('$session_user', '$class_id', '$final_grade');";
			//echo $final_grade_query;
			mysql_query($final_grade_query);
		}
		else
		{
			$final_grade_query = "UPDATE final_grades SET grade='$final_grade' WHERE username='$session_user' AND class_id='$class_id';";
			mysql_query($final_grade_query);
		}


		?>
			<h3>Your Grades</h3>
			<table border="1" cellpadding="7">
			<tr>
			<th> Homework Average </td>
			<th> Quiz Average </td>
			<th> Test Average </td>
			<th> Project Average </td>
			<th> Final Grade Average </td>
			</tr>
			<tr>
			<td> <?php echo $homework_sum; ?> %</td>
			<td> <?php echo $quiz_sum; ?> %</td>
			<td> <?php echo $test_sum; ?> %</td>
			<td> <?php echo $project_sum; ?> %</td>
			<td> <?php echo $final_grade; ?> %</td>
			</tr>
			</table><br><br>

		<?php

		// Now get all the grades for this class and show the class average.
		$start_grade = 0;

		$num_students = "SELECT COUNT(*) rcount FROM final_grades WHERE class_id='$class_id';";
		$num_students = mysql_fetch_assoc(mysql_query($num_students));
		$num_students = $num_students['rcount'];

		$all_grades_query = "SELECT grade FROM final_grades WHERE class_id='$class_id';";
		$all_grades_query = mysql_query($all_grades_query);
		while ($row = mysql_fetch_assoc($all_grades_query))
		{
			//$start_grade = $row['grade'];
			$start_grade = $start_grade + $row['grade'];

		}
		
		echo "The class average is " . $start_grade/$num_students;
		//echo "Total: " . $start_grade;


}
else
	{
		header("Location: class.php");
	}
}
