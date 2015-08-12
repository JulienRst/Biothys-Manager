<?php
	
	require_once('../model/order.php');

	$order = new order($_GET["id"]);

	$order->setAlready_paid($_GET["val"]);

	$order->setToDatabase();

?>