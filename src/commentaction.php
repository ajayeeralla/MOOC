<?php
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');

	if (isset($_POST['commenting']))
	{
		$post_id = $_POST['post_id'];
		$class_id = $_POST['class_id'];
		// get class name for URL
		$class_query = "SELECT class_name FROM classes WHERE class_id='$class_id'";
		$class_result = mysql_query($class_query);
		$class_name_result = mysql_fetch_assoc($class_result);
		$class_name = $class_name_result['class_name'];
		$comment_body = $_POST['comment_content'];
		
		$date = `date +'%Y-%m-%d'`;
		$time = date('h:i:s A');

		$val = mysql_query('select * from comments');
		if ($val == FALSE) {
			mysql_query("CREATE TABLE comments(comment_id int(11), class_id varchar(100), Username varchar(100), comment mediumtext, comment_date date, comment_time varchar(20))");
		}
		$post_query = "INSERT INTO comments (comment_id, class_id, Username, comment, comment_date, comment_time) VALUES('$post_id', '$class_id', '$session_user', '$comment_body', '$date', '$time')";
		mysql_query($post_query);

		echo $post_query;
		header("Location: class.php?class=$class_name");
	}
}
else
{
	
}
