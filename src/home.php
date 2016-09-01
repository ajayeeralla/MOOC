<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
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
	?>
	<html>
	<head><link rel="stylesheet" type="text/css" href="HomeStyle.css"></head>
	<h1>Welcome  <?php echo $firstname ; ?> </h1> <br> 

	
		<!-- <a href="profile.php">View Profile</a><br><br> -->
		
	<h3>Search for new classes:</h3>
		<form method="POST" action="search.php">
		<input type="text" name="class"/><br>
		<input type="Submit" name="search" value="Search"/>
		</form>
	<?php

	echo $br;
	echo "Classes you are in: " . $br . $br;
	$class_query = "SELECT junction_student.Student, classes.class_name FROM junction_student  INNER JOIN classes ON junction_student.class_id=classes.class_id WHERE Student='$session_user';";
	$results = mysql_query($class_query);
	?>
	<table border="1" bordercolor="#C0C0C0" cellpadding="10">
    <?php
	while($row = mysql_fetch_assoc($results))
	{
		$class = $row['class_name'];
		?>
        <tr>
		<td><a href="class.php?class=<?php echo $class; ?>"><?php echo $class;?></a></td>
        <td><a href="delete_class.php?class=<?php echo $class;?>" onClick="return confirm('Are you sure you want to unenroll in this class?')">Drop class</a></td>
        </tr>
		<?php
	}
	
	?>
    </table>

	<script type="text/javascript">
	function confirmAction()
	{
    	var confirmed;
      	return confirmed;
	}
	</script>

	<?php
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


	echo $br . $br . "Anyone is free to make a class.  Try making one now by clicking "; ?> 
	<a href="makeclass.php">here</a><br><br>
	
   <!---<a href="logout.php">Logout</a>--->
	<?php
}

else 
{
	echo $_SESSION['login'];
	// send to login page with ?page=home.php so it brings em back here
}

?>
