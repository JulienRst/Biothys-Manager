<?php
	require_once('checkSession.php');
	require_once('../model/extraction.php');
	require_once('../model/order.php');

	$extraction = new extraction();

	$orders = $extraction->getOrders();

	include_once('../view/orders.php');
?>