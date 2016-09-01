<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	require('header.php');
	require('dbconnect.php');
	require('user_req.php');
$class_id=$_GET['classid'];
$type = "grades";
$files_query = "SELECT * FROM files WHERE filetype= '$type' and class_id ='$class_id'";
//in (select class_id from classes where professor='$session_user');";
	$results = mysql_query($files_query);
echo "<table border='1'>".$br;?>
<tr>
<th>No.</th>
<th>grades</th>
</tr><?php
	while($row = mysql_fetch_array($results))
	{
$fileid=$row['file_id'];
$filename=$row['filename']	;
echo "<tr>";
echo "<td>" . $fileid . "</td>";
//echo "<td>". '<a href="http://oscar.zapto.org/CS350/cryptobionic/eeralla/src1/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
echo "<td>". '<a href="http://localhost/src1/uploads/'.$filename.'">'.$filename.'</a>'. "</td>";
  

echo "</tr>";
		

//echo $assignment.$br;
 }
echo "</table>".$br.$br.$br;

// have to check for professor
$professor_match_query = "SELECT COUNT(*) rcount FROM classes WHERE class_id='$class_id' AND professor='$session_user';";
$professor_match_results = mysql_query($professor_match_query);
$professor_result = mysql_fetch_assoc($professor_match_results);
$professor_result = $professor_result['rcount'];

if ($professor_result == 1)
{
		//echo '<a href="upload_form.php?classid='.$class_id.'&type='.$type.'">Upload Graded Assignment</a><br><br>';
}


}
else
{
	// header login?name=allclasses
}?>
