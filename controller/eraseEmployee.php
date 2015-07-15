<?php

	require_once('../model/employee.php');
	try {
		$id = $_GET["id"];
	} catch (Exception $e){
		header('location:viewProducts.php');
		exit();
	}

	$employee = new employee($id);

	$employee->eraseOfDatabase();	

	header('location:viewEmployees.php');
	exit();



?>