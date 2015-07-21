<?php
	require_once('checkSession.php');
	require_once('../model/company.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$companies = $extraction->getCompany();

	include('../view/companies.php');


?>