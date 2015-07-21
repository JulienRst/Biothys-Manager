<?php

	$class = $_GET["class"];
	$id = $_GET["id"];
	$next = $_GET["next"];

	require_once('../model/'.$class.'.php');

	$item = new $class($id);
	$item->eraseOfDatabase();

	header('location:'.$next);
	exit();
?>