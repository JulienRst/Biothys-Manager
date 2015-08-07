<?php
	require_once('checkSession.php');
	require_once('../model/company.php');

	$company = new company();

	include('../view/addCompany.php');
?>