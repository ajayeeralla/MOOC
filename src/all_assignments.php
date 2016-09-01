<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");

	require('dbconnect.php');
	require('user_req.php');
    require('header.php');

    // First find the classes they are in.
    $class_query = "SELECT junction_student.Student, classes.class_name FROM junction_student INNER JOIN classes ON junction_student.class_id=classes.class_id WHERE Student='$session_user';";
	$results = mysql_query($class_query);
	while ($row = mysql_fetch_assoc($results))
	{
		$class = $row['class_name'];

		// Now get that class id
		$class_id = "SELECT class_id from classes WHERE class_name='$class';";
		$class_id = mysql_fetch_assoc(mysql_query($class_id));
		$class_id = $class_id['class_id'];

		// Now find the assignments for that class.
		$assignment_query = "SELECT * FROM assignments WHERE class_id='$class_id' ORDER BY due_date;";
		$assignment = mysql_query($assignment_query);
		?><hr> 
		<h3 style="padding-top: 10px; padding-left:5px"> Class: <?php echo $class; ?></h3>		
		<table style="position: relative; right:-15px; top:-30" border="1" cellpadding="10"> <?php
		while($row2 = mysql_fetch_assoc($assignment))
		{
			$file_id = $row2['file_id'];
			$due_date = $row2['due_date'];
			$assignment_name = $row2['assignment_name'];
			?>
			<tr>
			<td><a href="uploads/<?php echo $assignment_name; ?>"><?php echo $assignment_name; ?></a></td>
			<?php
			echo "<td>" . "Due Date: " . $due_date . "</td>";
		}
			?><br><br>
			</tr> </table>
			<?php
	}

}
else 
{
	// send to login page with ?page=home.php so it brings em back here
}

?>
