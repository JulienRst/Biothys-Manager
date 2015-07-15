<?php
	session_start();
	require_once('../model/error.php');
	require_once('../model/employee.php');
	
	if(isset($_SESSION["connected"])){
		
		if($_SESSION["connected"] == "false"){
			echo('DAMN ERROR CONNECTED == FALSE');
			$_SESSION["error"] = serialize(new error('Vous devez être connecté pour accéder à cette page'));
			header('location:viewConnection.php');
			exit();
		}

		$employee = new employee($_SESSION["employee"]);
		echo('You\'re connected : '.$employee->getName().' | <a href="disconnect.php">Disconnect</a>');
	} else {
		echo('DAMN ERROR CONNECTED IS MISSING !!');
		$_SESSION["error"] = serialize(new error('Vous devez être connecté pour accéder à cette page'));
		header('location:viewConnection.php');
		exit();
	}

?>