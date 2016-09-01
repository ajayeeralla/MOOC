<?php
$br = "<br />";
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
        require('user_req.php');

//	$session_user = $_SESSION['session_user'];

//	$query = "SELECT * FROM users WHERE Username='$session_user';";
//	$result = mysql_query($query);
//	$user_info = mysql_fetch_assoc($result);

	// This is when they first log in
	if (isset($_POST['FirstUpdate']))
	{
		$firstname = $_POST['FirstName'];
		$lastname = $_POST['LastName'];
		$age = $_POST['Age'];
		$val = mysql_query('select * from user_info');
		if ($val == FALSE) {
			mysql_query("CREATE TABLE user_info(FirstName VARCHAR(100),LastName VARCHAR(100), Username VARCHAR(100), Email VARCHAR(100), Phone VARCHAR(15), Age VARCHAR(3), Type VARCHAR(9))");
		}
		$update_query = "UPDATE user_info SET FirstName='$firstname', LastName='$lastname', Age='$age' WHERE Username='$session_user'";
		mysql_query($update_query);
		header("Location: index.php");
	}
	//////////////////////////////////////////////////////////////////////////////////////////
	else if (isset($_POST['UpdateProfile']))
	{
		if (isset($_POST['FirstName'])) $firstname = $_POST['FirstName']; else $firstname = "NULL";
		if (isset($_POST['LastName'])) $lastname = $_POST['LastName']; else $lastname = "NULL";
		if (isset($_POST['Age'])) $age = $_POST['Age']; else $age = "NULL";
		if (isset($_POST['Phone'])) $phone = $_POST['Phone']; else $phone = "NULL";


		$query = "UPDATE user_info SET 
		FirstName='$firstname', 
		LastName='$lastname',
		Age='$age',
		Phone='$phone' WHERE
		Username='$session_user';";
		mysql_query($query);
		
      	header("Location: profile.php");		
	}

}
else
{
	echo "not logged in.";
}
