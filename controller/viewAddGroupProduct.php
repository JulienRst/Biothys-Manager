<?php
	require_once('checkSession.php');
	require_once('../model/group_products.php');

	$groupProduct = new group_products();

	include('../view/addGroupProduct.php');

?>