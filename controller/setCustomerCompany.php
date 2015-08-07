<?php

	require_once('../model/company.php');

	$idCo = $_GET['idCo'];
	$idCu = $_GET['idCu'];

	$customer = new customer($idCu);
	$company = new company($idCo);

	$customer->setId_company($idCo);
	$customer->setToDatabase();

	$result = array('idContact' => $idCo,'contact' => $company->getName().' | '.$company->getDescription());

	echo(json_encode($result));

?>