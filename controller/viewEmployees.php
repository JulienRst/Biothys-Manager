<?php
	require_once('checkSession.php');
	require_once('../model/employee.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$employees = $extraction->getEmployee();

	include('../view/employees.php');


?>