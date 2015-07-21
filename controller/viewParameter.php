<?php

	require_once('../model/parameter.php');

	if(isset($_GET["id"])){
		$parameter = new parameter($_GET['id']);
	} else {
		$error;
	}

	include('../view/parameter.php');

?>