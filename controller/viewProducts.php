<?php
	require_once('../model/error.php');
	require_once('../model/extraction.php');
	require_once('checkSession.php');

	$extraction = new extraction();

	$groups = $extraction->getProductByGroup();

	include('../view/products.php');
?>