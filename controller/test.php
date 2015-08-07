<?php
	require_once('../model/order.php');

	$result = new order();
	
	$result->addToDatabase();
	
?>