<?php

	require("../model/extraction.php");
	$extraction = new extraction(0,0);
	$clients = $extraction->extractClientMail();

	include("../view/realBaseClient.php");
?>