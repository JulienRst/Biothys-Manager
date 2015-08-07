<?php
	require_once('checkSession.php');
	require_once('../model/company.php');

	if(isset($_GET["id"])){
		$company = new company($_GET["id"]);
	} else {
		$error;
	}

	include('../view/company.php');
?>