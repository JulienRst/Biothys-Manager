<?php

	require_once('../model/order.php');

	$date_shipment = (string)strtotime($_GET['date_shipment']);
	$date_receipt = (string)strtotime($_GET['date_receipt']);


	$order = new order($_GET['id']);

	$order->setDate_shipment($date_shipment);
	$order->setDate_receipt($date_receipt);

	$order->setToDatabase();
	header('location:viewOrder.php?id='.$_GET["id"]);
	exit();

?>