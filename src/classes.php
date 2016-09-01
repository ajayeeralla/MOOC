<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{

	require('header.php');
	require('dbconnect.php');
	require('user_req.php');

	echo $br;
	echo "Classes you are in: " . $br . $br;
	$class_query = "SELECT junction_student.Student, classes.class_name FROM junction_student  INNER JOIN classes ON junction_student.class_id=classes.class_id WHERE Student='$session_user';";
	$results = mysql_query($class_query);
	while($row = mysql_fetch_assoc($results))
	{
		$class = $row['class_name'];
		?>
		<a href="class.php?class=<?php echo $class; ?>"><?php echo $class;?></a><br>
		<?php
	}

	echo $br . $br;
				
	echo "Classes you teach:" . $br . $br;
	$professor_query = "SELECT * FROM classes WHERE professor='$session_user';";
	$results = mysql_query($professor_query);
	while($row = mysql_fetch_assoc($results))
	{
		$class = $row['class_name'];
		$class_id = $row['class_id']; ?>

		<a href="class.php?class=<?php echo $class; ?>"><?php echo $class;?></a><br>
		<?php	
	}



	echo $br.$br."Search for new classes:" . $br;
	?>
		<form method="POST" action="search.php">
		<input type="text" name="class"/><br>
		<input type="Submit" name="search" value="Search"/>
		</form> 
	

	
	<a href="makeclass.php">Create your own class</a><br><br>

	<a href="allclasses.php"> View all available classes</a>
	
   <!---<a href="logout.php">Logout</a>--->
	<?php
}


else
{
	header("Location: login.php");
}?>
