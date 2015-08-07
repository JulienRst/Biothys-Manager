<?php
	require_once('checkSession.php');
	require_once('../model/extraction.php');
	require_once('../model/partner.php');

	$extraction = new extraction();

	$partners = $extraction->get('partner');

	include_once('../view/partners.php');
?>