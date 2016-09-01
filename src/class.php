<head>
<link rel="stylesheet" type="text/css" href="cssClass.css">
</head>
<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');
	echo $br;
	// Checks if a class is specified in the URL
	if(isset($_GET['class']))
	{
		$class = $_GET['class'];
		echo "<div style='padding-left:20px;color:#3D6A7D;font-size:20px;'>". "Welcome to the " . $class . " page" ."</div>". $br ;
		// Find class id.
		$class_id_query = "SELECT class_id FROM classes WHERE class_name='$class'";
		$class_id_results = mysql_query($class_id_query);
		$class_id = mysql_fetch_assoc($class_id_results);
		$class_id = $class_id['class_id'];

		$professor_query = "SELECT professor FROM classes WHERE class_id='$class_id';";
		$professor_query_results = mysql_query($professor_query);
		$professor = mysql_fetch_assoc($professor_query_results);
		$professor = $professor['professor'];

		$professor_name_query = "SELECT * FROM user_info WHERE Username='$professor';";
		$professor_name_results = mysql_query($professor_name_query);
		$professor_name = mysql_fetch_assoc($professor_name_results);
		$professor_first_name = $professor_name['FirstName'];
		$professor_last_name = $professor_name['LastName'];

		//echo   "<a href='profile.php?user=$classmate_name'>$classmate_name</a>" . $br;
		echo "<div style='padding-left:30px;color:#3D6A7D;font-size:20px;'>"."Professor: " . "<a href='profile.php?user=$professor'>$professor_first_name  $professor_last_name </a>"."</div>";
		echo $br;

		// Find if the user is the professor
		$professor_match_query = "SELECT COUNT(*) rcount FROM classes WHERE class_name='$class' AND professor='$session_user';";
		$professor_match_results = mysql_query($professor_match_query);
		$professor_result = mysql_fetch_assoc($professor_match_results);
		$professor_result = $professor_result['rcount'];
		//echo "Prof res: " . $professor_result .$br;

		// Find if student is in the class
		$student_match_query = "SELECT COUNT(1) rcount FROM junction_student WHERE class_id='$class_id' AND Student='$session_user';";
		$student_match_results = mysql_query($student_match_query);
		$student_result = mysql_fetch_assoc($student_match_results);
		// If this returns a 1 then they are in the class, if it returns a 0 then they are not in the class.
		$student_result = $student_result['rcount'];


		//Display assignments for classid
		$type1="assignment";
		$type2="grades";
		echo '<a style="text-decoration:none; padding-left:50px;" href="class_assignments.php?classid=' . $class_id . '&type='.$type1.'">Assignments</a><br><br>';
		echo '<a style="text-decoration:none; padding-left:50px;" href="class_materials.php?classid=' . $class_id . '">Class Materials</a><br><br>';
		//echo '<a style="text-decoration:none; padding-left:50px;" href="class_grades.php?classid=' . $class_id . '&type='.$type2.'">Grades</a><br><br>';

		if (($student_result == 0) && ($professor_result == 0))
		{
			?>
				<a style="padding-left:50px" href="addclassaction.php?class=<?php echo $class; ?>">Register</a><br><br>
				<?php
		}
		// This is if they are the professor of the class. 
		if ($professor_result == 1)
		{
			$professor = true;
			echo "<div style='padding-left:30px;color:#3D6A7D;font-size:18px;'>"."Hello professor!" . $br . $br . "</div>";
			echo "<div style='padding-left:50px;'>".'<a style="text-decoration:none;" href="class_files.php?classid=' . $class_id . '">Files</a><br>'."</div>";
			echo "<div style='padding-left:50px;'>".'<a style="text-decoration:none;" href="submissions.php?classid=' .$class_id . '">Submissions</a><br>'."</div>";
			//echo "<div style='padding-left:50px;'>".'<a style="text-decoration:none;" href="upload_form.php?classid=' . $class_id . '">Add a File</a><br><br>'."</div>";
			$class_name = $_GET['class'];
			echo "<div style='padding-left:50px;'>".'<a style="text-decoration:none;" href="managestudents.php?class_id=' .$class_id . "&class=" . $class_name . '">Manage Students</a><br>'."</div>";
			echo $br;
		}
		else
		{
			echo '<a style="text-decoration:none; padding-left:50px;" href="class_grades.php?classid=' . $class_id .'">Grades</a><br><br>';

		}
		// get all the posts for the class
		$post_query = "SELECT * FROM posts WHERE class_id='$class_id' ORDER BY post_id desc;";
		$postresult = mysql_query($post_query);
		?>
			<div id="post">
			<h3>Post a question or comment here:</h3>
			<form method="POST" action="postaction.php"><textarea name="post_content" cols="40" rows="2"></textarea><br>
			<input type="hidden" name="class_id" value="<?php echo $class_id ?>"/>
			<input class="btn" type="submit" name="posting" value="Post" />
			</form>
			</div>
			<br>
			<h3>Recent Posts:</h3>

			<table style="margin-left:10px" border="1" bordercolor="#DDDDDD" style="background-color:#FFFFFF" width="100%" cellpadding="15" cellspacing="0">
			<?php
			while ($row=mysql_fetch_assoc($postresult))
			{

				$post_id = $row['post_id'];
				$post = $row['post'];
				$post_user = $row['Username'];
				$post_time = $row['post_time'];
				// Gets rid of leading zero's in time.
				$post_time = ltrim($post_time, 0);
				$post_date = $row['post_date'];

				?> <ul> <?php 
				echo  "User: "."<a href='profile.php?user=$post_user'>$post_user</a>". " @ " . $post_time . " On ". $post_date;
				echo $br;
				echo $post; ?> </ul> 
					<?php 
				
				$comment_query = "SELECT * FROM comments WHERE comment_id='$post_id'";
				$comments_results = mysql_query($comment_query);
				while ($row = mysql_fetch_assoc($comments_results))
				{
					$comment = $row['comment'];
					$comment_user = $row['Username'];
					$comment_time = $row['comment_time'];
					$comment_date = $row['comment_date'];

					echo  "<div style='padding-left:100px;'>"."<a href='profile.php?user=$comment_user'>$comment_user</a>". " @ ". $comment_time. " On ". $comment_date. $br. $comment . $br. "</div>";

				}

				?>
					<div id="post">
					<form method="POST" action="commentaction.php"><textarea name="comment_content" cols="40" rows="2"></textarea><br>
					<input type="hidden" name="post_id" value="<?php echo $post_id ?>"/>
					<input type="hidden" name="class_id" value="<?php echo $class_id ?>"/>
					<input class="btn" type="submit" name="commenting" value="Comment" />
					</form><br></div></td><br><br>
					<?php
			}
		?>

			</table>

			<?php

	}
	else
	{
		header("Location: home.php");
	}


}
