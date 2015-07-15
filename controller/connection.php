<?php
	
	require_once('../model/employee.php');
	require_once('../model/error.php');
	session_start();
	

	$login = $_GET["login"];
	$password = $_GET["password"];

	$employee = new employee();

	if($employee->checkPassword($login,$password)){
		$_SESSION["employee"] = $employee->getId();
		$_SESSION["connected"] = "true";
		header("location:viewIndex.php");
		exit();
	} else {
		$_SESSION["error"] = serialize(new error('Wrong Login / Password'));
		$_SESSION["connected"] = "false";
		header("location:viewConnection.php");
		exit();
	}
?>