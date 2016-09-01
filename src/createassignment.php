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
<body>

<form action="upload_file.php?class_id=<?php echo $class_id;?>" method="post"
enctype="multipart/form-data"><br>
<label for="file">Choose File:</label>
<input type="file" name="file" id="file"><br>
<input type="radio" name="type" value="Assignment">Assigm<br>
<input type="submit" name="submit" value="Submit">
</form>

</body>
</html> 



	


	<?php
}
else
{
	// send to login.php?page=makeclass
};?>
