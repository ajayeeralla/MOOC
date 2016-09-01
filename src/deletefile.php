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

	$fileid = $_GET['fileid'];
	$classid = $_GET['class_id'];
	$type = mysql_fetch_row(mysql_query("select filetype from files where file_id=$fileid;"))[0];


	$delete_file = "delete from files where file_id='$fileid';";
	$delete_assignment = "delete from assignments where file_id=$fileid;";
	$delete_submission = "delete from submissions where file_id=$fileid;";
	$delete_grade = "delete from grades where file_id=$fileid;";

	mysql_query($delete_file);
	mysql_query($delete_assignment);
	mysql_query($delete_submission);
	mysql_query($delete_grade);
	
	//echo "</br>" . $type;
	//echo "</br>" . $delete_query;
	header("Location: class_files.php?classid=$classid");
}
