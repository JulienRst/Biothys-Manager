<?php

	require_once('../model/customer.php');

	$customer = new customer($_GET["id"]);

	include('../view/customer.php');

?>