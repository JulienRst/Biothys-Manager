<?php

	require_once('../model/order.php');

	$order = new order($_GET["id"]);
	$order->setFinish($_GET["val"]);

	$order->setToDatabase();
?>