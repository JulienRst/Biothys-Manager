<?php

	require_once('../model/order.php');

	$order =  new order($_GET["id"]);
	$order->setCustomer_order_id($_GET["val"]);

	$order->setToDatabase();

?>