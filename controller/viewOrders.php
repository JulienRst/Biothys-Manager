<?php
	require_once('checkSession.php');
	require_once('../model/extraction.php');
	require_once('../model/order.php');

	$extraction = new extraction();

	if(isset($_GET["display"])){
		$display = $_GET["display"];
	} else {
		$display = "all";
	}

	$orders = $extraction->getOrders($display);

	include_once('../view/orders.php');
?>