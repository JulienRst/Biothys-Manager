<?php
	require_once('checkSession.php');
	require_once('../model/partner.php');

	$partner = new partner();

	include('../view/addPartner.php');
?>