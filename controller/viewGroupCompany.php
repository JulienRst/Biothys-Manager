<?php
	require_once('../model/error.php');
	require_once('../model/group_company.php');
	require_once('checkSession.php');

	if(isset($_GET["id"])){
		$group_company = new group_company($_GET["id"]);
		if($group_company == NULL){
			$error;
		}
	} else {
		$error;
	}

	include('../view/groupCompany.php');
?>