<?php

	require_once('../model/parameter.php');

	$parameter = new parameter();

	foreach($_GET as $key => $value){
		if($key != "next"){
			$nkey = "set".ucfirst($key);
			$parameter->$nkey($value);
		}
	}

	$parameter->addToDatabase();

	header('location:'.$_GET['next']);
?>