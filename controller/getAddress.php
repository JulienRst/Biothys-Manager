<?php

	$data = $_GET["address"];
	$data = json_decode($data,true);


	$idAddress = $data['id'];
	$idEmployee = $data['idFor'];
	$class = $data['for'];
	$step = $data['step'];

	require_once('../model/address.php');
	require_once('../model/'.$class.'.php');

	$address = new address($idAddress);
	$item = new $class($idEmployee);

	$method = "setId_".$step;

	$item->$method($idAddress);
	$item->setToDatabase();

	$result = array('idAddress' => $idAddress,'address' => $address->printAddress());

	echo(json_encode($result));

?>