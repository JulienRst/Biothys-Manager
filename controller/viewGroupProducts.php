<?php
	require_once('checkSession.php');
	require_once('../model/group_products.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$groups = $extraction->getGroup();

	include('../view/groupProducts.php');
?>