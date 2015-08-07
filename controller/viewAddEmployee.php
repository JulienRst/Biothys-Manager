<?php
	require_once('checkSession.php');
	require_once('../model/employee.php');


	$product = new employee();


	include('../view/addEmployee.php');
?>