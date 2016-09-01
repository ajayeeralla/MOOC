<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');

	if (isset($_GET['class']))
	{
		$class = $_GET['class'];
		// get that classes id
		$query = "SELECT class_id FROM classes WHERE class_name='$class';";
		$result = mysql_query($query);
		$class_id = mysql_fetch_assoc($result);
		//echo "Class id: " . $class_id['class_id'];

		$enter_class_id = $class_id['class_id'];
		$professor_query = "SELECT professor FROM classes WHERE class_id='$enter_class_id';";
		$professor_query_results = mysql_query($professor_query);
		$professor = mysql_fetch_assoc($professor_query_results);
		$professor = $professor['professor'];

		$professor_name_query = "SELECT * FROM user_info WHERE Username='$professor';";
		$professor_name_results = mysql_query($professor_name_query);
		$professor_name = mysql_fetch_assoc($professor_name_results);
		$professor_first_name = $professor_name['FirstName'];
		$professor_last_name = $professor_name['LastName'];

		// First have to check if the user logged in is the professor of the class.
		if ($session_user == $professor)
		{
			?> <h3  style="padding-top: 10px; padding-left:1px;"> Add a student </h3> <?php
			if (isset($_GET['user'])) 
			{
				$user = $_GET['user'];
				?>
				<form method="POST" action="managestudents-r.php">
				Student Username: <input type="text" name="student" value=<?php echo $user;?>><br>
				Authentication Key: <input type="text" name="key"><br>
				<input type="submit" name="add" value="Add Student">
				</form>
				<?php		
			}
			else
			{
				?>
				<form method="POST" action="managestudents-r.php">
				Student Username: <input type="text" name="student"><br>
				Authentication Key: <input type="text" name="key"><br>
				<input type="submit" name="add" value="Add Student">
				</form>
			<?php			
			}

			?>
				<h3  style="padding-top: 10px; padding-left:1px;"> Students In This Class </h3>
			<?php
				$student_query = "SELECT * FROM junction_student WHERE class_id='$enter_class_id';";
				
				$student_query = mysql_query($student_query);
				
				?>
				<table border="1" bordercolor="#C0C0C0" cellpadding="10">
				<tr>
				<th> First Name </th>
				<th> Last Name </th>
				<th> Email </th>
				<th> Username </th>
				<th> Drop Student</th>
				</tr>

				<?php
				while($row = mysql_fetch_assoc($student_query))
				{
					$username = $row['Student'];
					// Now find all the user info
					$user_info = "SELECT * from user_info WHERE Username='$username';";
					$user_info = mysql_fetch_assoc(mysql_query($user_info));
					$firstname = $user_info['FirstName'];
					$lastname  = $user_info['LastName'];
					$email     = $user_info['Email'];
					echo "<tr>";
					echo "<td>" . $firstname . "</td>";
					echo "<td>" . $lastname . "</td>";
					echo "<td>" . $email . "</td>";
					echo "<td>" . $username . "</td>";

			        ?>
					<td><a href="deletestudent.php?class_id=<?php echo $enter_class_id . "&";?>student=<?php echo $username;?>" onClick="return confirm('Are you sure you want to drop this student from the class?')">Drop Student</a></td>
					<?php

					echo "</tr>";
				}

				?>
				<script type="text/javascript">
				function confirmAction()
				{
    				var confirmed;
				   	return confirmed;
				}
				</script>
				
				<?php
		}
		else
		{
			//echo "no";
		}
	}
	else
	{
		//header("Location: home.php");
	}
}
else
{
	echo "Not logged in";
}
