<?php
$br = "<br />";
session_start();
if (is_null($_SESSION['login'])) header("Location: index.php");
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');	
	require('header.php');

}
else
{


}