<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	require('header.php');
	require('dbconnect.php');
	require('user_req.php');

	// Filter by class id or by name

	$class_query = "SELECT * FROM classes ORDER BY class_name;";
	$class_query_results = mysql_query($class_query);
	
	?>
		<h3> All Classes </h3> 
	<?php

	while($row = mysql_fetch_assoc($class_query_results))
	{
		$class_name = $row['class_name'];
		?>
		<?php 
		echo '<a href="class.php?class=' . $class_name . '">' .  $class_name . '</a>' . $br . $br;	
	}

}
?>
