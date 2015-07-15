<?php

	require_once('../model/address.php');
	require_once('../model/employee.php');

	$idAddress = $_GET["idAddress"];
	$idEmployee = $_GET["idEmployee"];

	$address = new address($idAddress);
	$employee = new employee($idEmployee);

	$employee->setId_address($idAddress);
	$employee->setToDatabase();

	$result = array('idAddress' => $idAddress,'address' => $address->printAddress());

	echo(json_encode($result));

?>