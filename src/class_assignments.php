<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');
	echo $br;
if(isset($_GET['classid']))
	{


$class_id=$_GET['classid'];
//$type = $_GET['type'];
$files_query = "SELECT * FROM assignments WHERE class_id='$class_id'";
$results = mysql_query($files_query);
//echo "Query: " . $files_query . $br;
echo "<table border='1' cellpadding='7'>".$br;?>
<tr>

<th>Name</th>
<th>Type</th>
<th>Due date</th>
<th>Submit</th>
</tr>
<?php
//check for tables assignments and files, if not, make em.
$val = mysql_query('select * from files');
if ($val == FALSE) {
	mysql_query("CREATE TABLE files(file_id int , class_id int(11), filename varchar(100),filetype varchar(100));");
}
$val2 = mysql_query('select * from assignments');
if ($val2 == FALSE) {
	mysql_query("CREATE TABLE assignments (class_id int(11), assignment_name varchar(100), assignment_type varchar(100), grade float, due_date date, file_id int);");
}
	while($row = mysql_fetch_array($results))
	{
		$fileid=$row['file_id'];
		$assign_name=$row['assignment_name']	;
        $due_date=$row['due_date'];
        $assign_type=$row['assignment_type'];
		echo "<tr>";
		//echo "<td>" . $fileid . "</td>";
		echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'.$assign_name.'">'.$assign_name.'</a>'. "</td>";
		echo "<td>" . $assign_type . "</td>";
		echo "<td>" . $due_date . "</td>";
		echo "<td> <a href='submit_assignment.php?class_id=$class_id&file_id=$fileid'>Submit</a> </td>"; 
		echo "</tr>";	
	}
echo "</table>".$br.$br.$br;
}
else
	{
		header("Location: class.php");
	}
}
