<?php
	require_once('checkSession.php');
	require_once('../model/group_company.php');

	$gc = new group_company();

	include('../view/addGroupCompany.php');

?>