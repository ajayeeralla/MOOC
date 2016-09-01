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
		$val = mysql_query('select * from submissions');
			if ($val == FALSE) {
				mysql_query("CREATE TABLE submissions(class_id varchar(20), assignment_id int(11), file_id int(11), username varchar(100), filename varchar(100), submit_date date);");
			}
		$files_query = "SELECT * FROM submissions WHERE class_id='$class_id'";
		$results = mysql_query($files_query);

		if (isset($_GET['e']) && $_GET['e'] == "s")
		{
			echo "Grade is: " . $_POST['i_grade'];
		}

		else if (isset($_GET['e']) && $_GET['e'] == "t")
		{

			$url_id = $_GET['file_id'];
			echo "<table border='1' cellpadding='7'>".$br;?>
			<tr>
			<th>Student</th>
			<!-- <th>FileID</th> -->
			<th>Assignment</th>
			<th>File Name</th>
			<th>Date Submitted</th>
			<th>Grade</th>
			</tr> <?php
			while($row = mysql_fetch_array($results))
			{
				$fileid=$row['file_id'];
				$username=$row['username']	;
				$filename=$row['filename'];
				$submit_date=$row['submit_date'];
				$assignment_name = mysql_fetch_row(mysql_query("select filename from files where file_id=$row[assignment_id];"))[0];
				$grade = mysql_fetch_row(mysql_query("select grade from grades where file_id=$fileid;"))[0];
				echo "<tr>";
				echo "<td>" . $username . "</td>";
				//echo "<td>" . $fileid . "</td>";
				echo "<td>" .'<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'. $assignment_name . '">'.$assignment_name.'</a>'. "</td>";
				echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
				echo "<td>" . $submit_date . "</td>"; 
				// Get possible grade from table
				$p_grade = "SELECT grade FROM grades WHERE file_id='$fileid';";
				$p_grade = mysql_fetch_assoc(mysql_query($p_grade));
				$p_grade = $p_grade['grade'];
				if ($p_grade == null) $p_grade = "0";
				if ($fileid == $url_id)
				{
					?>
					<td> 	<form method="POST" action="updategrade.php">
						  	<input type="hidden" name="student" value="<?php echo $username;?>"/>
						  	<input type="hidden" name="fileid" value="<?php echo $fileid;?>"/>
						  	<input type="hidden" name="class_id" value="<?php echo $class_id;?>"/>
							<input size="5" value="<?php echo $p_grade; ?>" name="input_grade" type="text"/> </td> 

					</tr><?php
				}
				else
				{
					echo "<td>" . $grade . "</td>";
				}
			
			}
			echo "</table>".$br;
			?> <input type="Submit" value="Update Grades" action="updategrade.php">
			<?php
			echo "</form>";
			echo $br.$br;
	
		}
		else
		{
			echo "<table border='1' cellpadding='12'>".$br;?>
			<tr>
			<th>Student</th>
			<!-- <th>FileID</th> -->
			<th>Assignment</th>
			<th>File Name</th>
			<th>Date Submitted</th>
			<th>Grade</th>
			<th> Edit Grade </th>
			</tr> <?php
			while($row = mysql_fetch_array($results))
			{
				$fileid=$row['file_id'];
				$username=$row['username']	;
				$filename=$row['filename'];
				$submit_date=$row['submit_date'];
				$assignment_name = mysql_fetch_row(mysql_query("select filename from files where file_id=$row[assignment_id];"))[0];
				$grade = mysql_fetch_row(mysql_query("select grade from grades where file_id=$fileid;"))[0];
				echo "<tr>";
				echo "<td>" . $username . "</td>";
				//echo "<td>" . $fileid . "</td>";
				echo "<td>" .'<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'. $assignment_name . '">'.$assignment_name.'</a>'. "</td>";
				echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
				echo "<td>" . $submit_date . "</td>";
				if ($grade == null) $grade = "0";
				echo "<td>" . $grade . "</td>";
				echo "<td>" . "<a href='submissions.php?classid=$class_id&e=t&file_id=$fileid'>Edit Grade</a>" . "</td>";
				echo "</tr>";	
			}
			echo "</table>".$br.$br.$br;
		}
	}
	else
	{
		header("Location: class.php");
	}
}
