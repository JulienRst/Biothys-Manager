<?php
	require_once('checkSession.php');
	require_once('../model/order.php');
	$order = new order();
	include('../view/addOrder.php');
?>