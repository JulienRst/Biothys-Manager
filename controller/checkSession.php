<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	include_once('getText.php');
	require_once('../model/error.php');
	require_once('../model/employee.php');
	
	if(isset($_SESSION["connected"])){
		
		if($_SESSION["connected"] == "false"){
			$_SESSION["error"] = serialize(new error('Vous devez être connecté pour accéder à cette page'));
			header('location:viewConnection.php');
			exit();
		}

		$employee = new employee($_SESSION["employee"]);
	} else {
		$_SESSION["error"] = serialize(new error('Vous devez être connecté pour accéder à cette page'));
		header('location:viewConnection.php');
		exit();
	}

?>