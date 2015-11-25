<?php
	require_once('../model/order.php');

	$order = new order();
	$order->setId_company($_GET["id_company"]);
	$order->setId_employee($_GET["id_employee"]);
	$order->setBilling_period_bis($_GET["billing_period_bis"]);
	$order->setDate_issuing(strtotime($_GET["date_issuing"]));
	$order->setDate_received(strtotime($_GET["date_received"]));
	$order->setDate_entry(time());

	$id_order = $order->addToDatabase();

	header('location:viewOrder.php?id='.$id_order);
?>