<?php

	require_once('../model/order.php');

	$order = new order($_GET['id']);

	if($_GET['date_shipment'] != ""){
		$date_shipment = DateTime::createFromFormat('!d-m-y', $_GET['date_shipment'])->getTimestamp();
		$order->setDate_shipment($date_shipment);
	}

	if($_GET['date_receipt'] != ""){
		$date_receipt = DateTime::createFromFormat('!d-m-y', $_GET['date_receipt'])->getTimestamp();
		$order->setDate_receipt($date_receipt);
	}

	if($_GET['date_shipment_expected'] != ""){
		$date_shipment_expected = DateTime::createFromFormat('!d-m-y', $_GET['date_shipment_expected'])->getTimestamp();
		$order->setDate_shipment_expected($date_shipment_expected);
	}


	$order->setToDatabase();
	header('location:viewOrder.php?id='.$_GET["id"]);
	exit();

?>