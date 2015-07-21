<?php

	require_once('../model/extraction.php');
	require_once('../model/order.php');

	$extraction = new extraction();

	$results = $extraction->getOrders();

	var_dump($results);

	include_once('../view/orders.php');
?>