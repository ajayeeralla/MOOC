<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	require('header.php');
	require('dbconnect.php');
	require('user_req.php');
//echo $class_id;
$class_id=$_GET['classid'];
$type = "assignment";
$files_query = "SELECT * FROM files WHERE filetype= '$type' and class_id ='$class_id'";
//in (select class_id from classes where professor='$session_user');";
	$results = mysql_query($files_query);
echo "<table border='1'>".$br;?>
<tr>
<th>No.</th>
<th>Assignments</th>
</tr><?php
	while($row = mysql_fetch_array($results))
	{
$fileid=$row['file_id'];
$filename=$row['filename']	;
echo "<tr>";
echo "<td>" . $fileid . "</td>";
echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/eeralla/src1/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
//echo "<td>". '<a href="http://localhost/src1/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
  

echo "</tr>";
		

//echo $assignment.$br;
 }
echo "</table>".$br.$br.$br;
echo '<a href="upload_form.php?classid='.$class_id.'&type='.$type.'">Upload</a><br><br>';

}
else
{
	// header login?name=allclasses
}?>
