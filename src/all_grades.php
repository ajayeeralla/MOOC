<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");

//$class = $_GET['class'];
	require('dbconnect.php');
	require('user_req.php');
   	require('header.php');

	?><h3 style:"padding-left:10px;"><?php echo "Classes you are in"?></h3><br /><?php

   	$class_query = "SELECT junction_student.Student, classes.class_name FROM junction_student  INNER JOIN classes ON junction_student.class_id=classes.class_id WHERE Student='$session_user';";
   	$results = mysql_query($class_query);
   	while($row = mysql_fetch_assoc($results))
   	{
		$class = $row['class_name'];
      
		// Get class id
		$query = "SELECT class_id FROM classes WHERE class_name='$class';";
		$query = mysql_query($query);
		$query = mysql_fetch_assoc($query);
		$class_id = $query['class_id'];

		?>
      <a href="class_grades.php?classid=<?php echo $class_id; ?>"><?php echo $class;?></a><br>
      <?php
   	}

	$type='grades';
	echo $br;
	/* 
	?> <h3> Classes you teach </h3> <?php
	$professor_query = "SELECT * FROM classes WHERE professor='$session_user';";
	$results = mysql_query($professor_query);
	while($row = mysql_fetch_assoc($results))
	{
        $class = $row['class_name'];
		$class_id = $row['class_id']; ?>
		<a href="class_grades.php?classid=<?php echo $class_id; ?>"><?php echo $class;?></a><br>
       		
		<?php

	}
*/
echo $br.$br.$br;

}

else 
{
	echo $_SESSION['login'];
        // send to login page with ?page=home.php so it brings em back here
}

?>


       
