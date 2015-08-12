<?php
	require_once('checkSession.php');
	require_once('../model/company.php');
	require_once('../model/extraction.php');

	if(isset($_GET["id"])){
		$company = new company($_GET["id"]);
		$extraction = new extraction();
		$orders = $extraction->getOrderFromCompany($_GET["id"]);
	} else {
		$error;
	}

	include('../view/company.php');
?>