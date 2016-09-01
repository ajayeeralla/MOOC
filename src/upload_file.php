<?php
require('dbconnect.php');

if (!file_exists('uploads')) {
    echo "please create a directory 'uploads' with the owner being http";
} else {

$target_path = "uploads/";
$class_id = $_GET['classid'];
//$type =$_GET['type'];
$file_type = $_POST['file_type'];
$due_date = $_POST['due_date'];
if ($file_type == "Materials")
{
	$due_date = "None";
}
$assignment_name = $_POST['assignment_name'];

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
$post_query = "INSERT INTO files (file_id, class_id, filename,filetype) VALUES('$fileid', '$class_id', '$filename','$file_type')";

echo "<br> $post_query";

//check to see if assignments table exists, if not create it
$val2 = mysql_query('select * from assignments');
if ($val2 == FALSE) {
	mysql_query("CREATE TABLE assignments (class_id int(11), assignment_name varchar(100), assignment_type varchar(100), grade float, due_date date, file_id int);");
}
$assignment_query = "INSERT INTO assignments (class_id, assignment_name, assignment_type, grade, due_date, file_id) VALUES('$class_id', '$filename', '$file_type', '', '$due_date', '$fileid');";

echo "<br> $assignment_query";

mysql_query($post_query);
echo "<br> $file_type";
header("Location: class_files.php?classid=$class_id");
//add to the assignments table if the uploaded file isn't a class material.
if ($file_type != "Materials"){
	mysql_query($assignment_query);
}

}
?> 

