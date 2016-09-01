<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	if ($_SESSION['session_user'] ==  null) header("Location: logout.php");

	require('dbconnect.php');
	require('user_req.php');
    require('header.php');

    $username = $_GET['student'];
    $class_id = $_GET['class_id'];

    $class_query = "SELECT class_name FROM classes WHERE class_id='$class_id';";
    $class_query = mysql_fetch_assoc(mysql_query($class_query));
    $class = $class_query['class_name'];

    $delete_query = "DELETE FROM junction_student WHERE Student='$username' AND class_id='$class_id';";

    mysql_query($delete_query);
    header("Location: managestudents.php?class_id=$class_id&class=$class");
}
else
{

}