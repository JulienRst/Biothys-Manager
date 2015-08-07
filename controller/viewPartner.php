<?php
	require_once('checkSession.php');
	require_once('../model/partner.php');

	if(isset($_GET["id"])){
		$partner = new partner($_GET["id"]);
	} else {
		$error;
	}

	include('../view/partner.php');
?>