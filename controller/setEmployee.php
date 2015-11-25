<?php

	require_once('../model/employee.php');

	$employee = new employee();
	$_GET["birthdate"] = strtotime($_GET["birthdate"]);
	foreach($_GET as $key => $value){

		if($key != "next" && $value != ""){
			echo($key.' -> '.$value.'<br/>');
			$nkey = "set".ucfirst($key);
			echo($nkey.'<br/>');
			try {
				$employee->$nkey($value);
			} catch(Exception $e){
				echo('shit');
			}
		}
	}
	$employee->setToDatabase();

	header('location:'.$_GET['next']);
?>