<?php

	require_once('../model/perfume.php');

	if(isset($_GET["id"])){
		$perfume = new perfume($_GET["id"]);

		$perfume->eraseOfDatabase();
	}


	header("location:viewPerfumes.php");

?>