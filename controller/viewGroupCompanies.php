<?php
	require_once('checkSession.php');
	require_once('../model/group_company.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$group_companies = $extraction->get("group_company");

	include('../view/groupCompanies.php');
?>