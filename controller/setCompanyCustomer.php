<?php

	require_once('../model/company.php');

	$idCo = $_GET['idCo'];
	$idCu = $_GET['idCu'];

	$customer = new customer($idCu);

	$company = new company($idCo);
	$company->setId_contact($idCu);
	$company->setToDatabase();

	$result = array('idContact' => $idCu,'contact' => $customer->getName().' | '.$customer->getMail().' | '.$customer->getPhone_number());

	echo(json_encode($result));


?>