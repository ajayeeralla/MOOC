<?php
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');
}

if (!file_exists('uploads')) {
	echo "please create a directory 'uploads' with the owner being http";
} else {

	$target_path = "uploads/";
	$class_id = $_GET['classid'];
	$assignment_id = $_GET['fileid'];
	$submit_date = $_POST['submit_date'];
	$username = $session_user;

	//the type will always be submission
	$file_type = "Submission";
	
	echo "Type: " . $file_type . "<br />";
	$target_path = $target_path . basename( $_FILES['file']['name']); 
	$filename = basename( $_FILES['file']['name']);
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		echo "The file ". $filename. 
			" has been uploaded";
		echo "<br>classid: " . $class_id;

		//header("Location: listassignments.php");

	} else{
		echo "There was an error uploading the file, please try again!";
	}

	//get highest file id from the table and increment it by 1
	if (mysql_query('select * from files') == FALSE){
		$fileid=1;
		$highestid=1;
	}
	else{
		$highestid = mysql_fetch_row(mysql_query("select max(file_id) from files;"))[0];
		$fileid = $highestid + 1;
	}

	echo "<br>this is the highest file id:  $highestid";
	echo "<br>this is the new file id:  $fileid";

	
	//check to see if files table exists, if not create it
	$val = mysql_query('select * from files');

	if ($val == FALSE) {
		mysql_query("CREATE TABLE files(file_id int , class_id int(11), filename varchar(100), filetype varchar(100));");
	}
	//delete the file if a repeat submission
	//$exists = mysql_query("select * from submissions where username='$username';");
	//if (mysql_fetch_array($exists) !== FALSE) {
	//	mysql_query("delete from files where ");
	//}
	$post_query = "INSERT INTO files (file_id, class_id, filename,filetype) VALUES('$fileid', '$class_id', '$filename','$file_type')";
	

//	echo "<br> $post_query";

	//check to see if submissions table exists, if not create it
	$val2 = mysql_query('select * from submissions');
	if ($val2 == FALSE) {
		mysql_query("CREATE TABLE submissions(class_id varchar(20), assignment_id int(11), file_id int(11), username varchar(100), filename varchar(100), submit_date date);");
	}
	
	//update submissions table if submission exists, otherwise update it
	$exists = mysql_query("select * from submissions where assignment_id='$assignment_id' and username='$username';");
	if (mysql_fetch_array($exists) !== FALSE) {
		$submission_query = "UPDATE submissions SET file_id='$fileid', filename='$filename', submit_date='$submit_date' WHERE username='$username';";
	}
	else {
		$submission_query = "INSERT INTO submissions (class_id, file_id, assignment_id, username, filename, submit_date) VALUES('$class_id', '$fileid', $assignment_id, '$username', '$filename', '$submit_date');";
	}
	

//echo "<br> $submission_query";

mysql_query($post_query);
mysql_query($submission_query);
//echo "<br> $file_type";
//echo $post_query;
//echo $submission_query;
header("Location: class_assignments.php?classid=$class_id");

}
?> 
