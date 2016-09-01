<?php
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');

	if (isset($_POST['posting']))
	{
		$class_id = $_POST['class_id'];
		// get class name for URL
		$class_query = "SELECT class_name FROM classes WHERE class_id='$class_id'";
		$class_result = mysql_query($class_query);
		$class_name_result = mysql_fetch_assoc($class_result);
		$class_name = $class_name_result['class_name'];
		$post_body = $_POST['post_content'];
		
		$date = `date +'%Y-%m-%d'`;
		
		//$military_time = `date + '%T'`;
		$time = date('h:i:s A');

		//echo "time: " . $time;

		$val = mysql_query('select * from posts');
		if ($val == FALSE) {
			mysql_query("CREATE TABLE posts(post_id int(11), class_id varchar(100), Username varchar(100), post mediumtext, post_date date, post_time varchar(20))");
		}
		$post_query = "INSERT INTO posts (post_id, class_id, Username, post, post_date, post_time) VALUES('', '$class_id', '$session_user', '$post_body', '$date', '$time')";
		mysql_query($post_query);

		header("Location: class.php?class=$class_name");
	}
	
}
else
{
	
}
