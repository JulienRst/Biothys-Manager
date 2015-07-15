<?php

	require_once('../model/employee.php');
	require_once('../model/error.php');

	$employee = new employee();

	if($_GET){
		foreach($_GET as $key => $value){
			if($key != "next"){
				$nattr = "set".ucfirst($key);
				$employee->$nattr($value);
			}
		}
	}

	print_r($employee);

	try {
		$employee->addToDatabase();
	} catch(Exception $e){
		echo('Problem at '.$e->getLine().' from controller addEmployee :'.$e->getMessage());	
	}

	header('location:'.$_GET["next"]);
?>