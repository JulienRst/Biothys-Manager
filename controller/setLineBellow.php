<?php

	require_once('../model/order.php');

	$order =  new order($_GET["id"]);
	$order->setLine_bellow($_GET["val"]);

	$order->setToDatabase();

?>