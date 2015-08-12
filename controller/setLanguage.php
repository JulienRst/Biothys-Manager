<?php

	session_start();
	$_SESSION["lng"] = $_GET["lng"];
	header('location:'.$_GET["next"]);	

?>