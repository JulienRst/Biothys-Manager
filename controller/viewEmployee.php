<?php
	require_once('../model/error.php');
	require_once('../model/employee.php');
	require_once('../model/extraction.php');
	require_once('checkSession.php');

	if(isset($_GET["id"])){
		$employee= new employee($_GET["id"]);
		if($employee == NULL){
			$error;
		}
		$extraction = new extraction();
		$orders = $extraction->getOrderFromEmployee($_GET["id"]);
	} else {
		$error;
	}


	include('../view/employee.php');
?>