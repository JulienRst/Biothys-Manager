<?php

	require_once('../model/perfume.php');

	if(isset($_GET["id"])){
		$perfume = new perfume($_GET['id']);
	} else {
		$error;
	}

	include('../view/perfume.php');

?>