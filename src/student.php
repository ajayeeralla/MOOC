<?php

session_start();
if($_SESSION['login'] == 1)
{
	require('dbconnect.php');
	require('user_req.php');
	require('header.php');

	
}
else
{
}
