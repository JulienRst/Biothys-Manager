<?php

	require_once('../model/order.php');

	$date_shipment = DateTime::createFromFormat('!d-m-y', $_GET['date_shipment'])->getTimestamp();
	$date_receipt = DateTime::createFromFormat('!d-m-y', $_GET['date_receipt'])->getTimestamp();

	$order = new order($_GET['id']);

	$order->setDate_shipment($date_shipment);
	$order->setDate_receipt($date_receipt);

	$order->setToDatabase();
	header('location:viewOrder.php?id='.$_GET["id"]);
	exit();

?>