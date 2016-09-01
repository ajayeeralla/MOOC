<?php
	session_start();
	$b = "<br />";
	
	require('user_req.php');	
	require('dbconnect.php');
	
	$key = $_GET['k'];
	$session_user = $_GET['u'];
	
	$query = "SELECT * FROM temp_users WHERE Username='$session_user' AND auth_key='$key';";
	//echo $query . $b;
	$ex_query = mysql_query($query);
	$result = mysql_fetch_assoc($ex_query);

	$email = $result['Email'];
	$password = $result['Password'];
	$key = $result['auth_key'];

	//echo "Registration complete! You can now log in with the session_user " . $session_user . " and the password you set.";
	
	$val = mysql_query('select * from users');
	if ($val == FALSE) {
		mysql_query("CREATE TABLE users(Username VARCHAR(100),Password VARCHAR(100))");
	}
	
	$in_users = "INSERT INTO users (Username, Password) VALUES('$session_user', '$password');";
	mysql_query($in_users);
	$student = "Student";
	$val = mysql_query('select * from user_info');
	if ($val == FALSE) {
		mysql_query("CREATE TABLE user_info(FirstName VARCHAR(100),LastName VARCHAR(100), Username VARCHAR(100), Email VARCHAR(100), Phone VARCHAR(15), Age VARCHAR(3), Type VARCHAR(9))");
	}
	$in_temp = "INSERT INTO user_info (Email, Username, Type) VALUES('$email', '$session_user', '$student');";
	mysql_query($in_temp);
	mysql_query("DELETE FROM temp_users where Email='$email' AND auth_key='$key';");

	$_SESSION['login'] = 1;
	$_SESSION['session_user'] = $session_user;
	session_write_close();
	header("Location: first.php");
	?>

	<?php	

?>
