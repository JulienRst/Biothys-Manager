<?php
	require_once('checkSession.php');
	require_once('../model/parameter.php');

	$parameter = new parameter();

	include('../view/addParameter.php');

?>