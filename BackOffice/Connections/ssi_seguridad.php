<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION))
	@session_start();

if(!isset($_SESSION['admin']) || $_SESSION['admin']=='' )	{
	header("location: index.php");
	die();
}
	