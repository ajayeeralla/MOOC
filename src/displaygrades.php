<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	require('header.php');
	require('dbconnect.php');
	require('user_req.php');


$files_query = "SELECT * FROM files WHERE filetype= 'grades';";
	$results = mysql_query($files_query);
echo "<table border='1'>".$br;?>
<tr>
<th>No.</th>
<th>Grades</th>
</tr><?php
	while($row = mysql_fetch_array($results))
	{
		echo "<tr>";
echo "<td>" . $row['file_id'] . "</td>";
  echo "<td>" . $row['filename'] . "</td>";

echo "</tr>";
		

//echo $assignment.$br;
 }
echo "</table>".$br.$br.$br;
echo '<a href="upload_form.php?classid=' . $class_id . '">Upload</a><br><br>';

}
else
{
	// header login?name=allclasses
}?>
