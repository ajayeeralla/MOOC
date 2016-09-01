<?php
$br = "<br />";
session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
   require('user_req.php');
   require('header.php');

//	$session_user = $_SESSION['session_user'];

	if (isset($_POST['search']))
	{
		$class = $_POST['class'];

		//echo $class[0];
		$re = $class[0];
		$query = "SELECT class_name FROM classes WHERE class_name REGEXP '^$re';";
		$exec = mysql_query($query);
		//$classes = mysql_fetch_assoc($exec);
		//while ($classes)
		//{
			//echo "Classes: " . $classes['class_name'];	
	//	}
		echo "Results: " . $br . $br;
		while($row = mysql_fetch_assoc($exec))
		{
			$class = $row['class_name'];
			?>
			<!-- <a href="addclassaction.php?class=<?php echo $class; ?>"><?php echo $class;?></a><br><br> -->
			<a href="class.php?class=<?php echo $class; ?>"><?php echo $class;?></a><br><br>
			<?php
		}
		
	}
	else
	{
		header("Location: home.php");
	}
}
