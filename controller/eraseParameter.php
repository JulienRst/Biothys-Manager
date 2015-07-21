<?php

	require_once('../model/parameter.php');

	if(isset($_GET["id"])){
		$parameter = new parameter($_GET["id"]);

		$parameter->eraseOfDatabase();
	}


	header("location:viewParameters.php");

?>