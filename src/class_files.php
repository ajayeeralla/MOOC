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
$files_query = "SELECT * FROM files WHERE class_id='$class_id'";
$results = mysql_query($files_query);
//echo "Query: " . $files_query . $br;
echo "<table border='1' cellpadding='10'>".$br;?>
<tr>
<th>Id</th>
<th>file</th>
<th>type</th>
<th>Delete</th>
</tr>
<?php
//check for tables assignments and files, if not, make em.
$val = mysql_query('select * from files');
if ($val == FALSE) {
	mysql_query("CREATE TABLE files(file_id int , class_id int(11), filename varchar(100), filetype varchar(100));");
}
	while($row = mysql_fetch_array($results))
	{
		$fileid=$row['file_id'];
		$filename=$row['filename'];
                 $filetype=$row['filetype'];
		echo "<tr>";
		echo "<td>" . $fileid . "</td>";
		echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/fabbricm/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
		echo "<td>" . $filetype . "</td>";
		echo "<td>" . "<a href='deletefile.php?fileid=$fileid&class_id=$class_id'>Delete File</a>";
		echo "</tr>";	
	}
echo "</table>".$br.$br.$br;
}
else
	{
		header("Location: class.php");
	}
	require('upload_form.php');
}
