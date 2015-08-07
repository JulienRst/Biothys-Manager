<?php

	require_once('../model/order.php');

	$order = new order($_GET["id"]);
	$order->setReady($_GET["val"]);

	$order->setToDatabase();
?>