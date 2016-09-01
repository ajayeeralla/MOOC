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

	<table border='0' cellpadding="7">
	<tr>
	<form method="POST" action="makeclassaction.php"><br>
	<td>Class Name </td> <td><input type="text" size="40" name="classname"/><br></td>
	
	</tr>
	</table>

	
	<p style="padding-left:9px"> Here you specify the weights of how your class will be graded.<br>
	Each field can have any value (including 0) but the total must add up to 100.
	</p>
	
	<table border='0' cellpadding="7">
	<tr>
		<td>Tests </td> <td><input type="number" name="Test"/>%<br></td>
	</tr>
	<tr>
		<td>Quizes </td> <td><input type="number" name="Quiz"/>%<br></td>
	</tr>

	<tr>
		<td> Homework </td> <td><input type="number" name="Homework"/>%<br></td>
	</tr>

	<tr> 
		<td> Projects </td> <td><input type="number" name="Project"/>%<br></td>
	</tr>

	<br>

	</table>
	<br>
	<td><input type="Submit" name="makeclass" value="Create Class"/></td>
	</form>
	


	<?php
}
else
{
	// send to login.php?page=makeclass
}
