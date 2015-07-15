<?php

	require_once('../model/perfume.php');

	$perfume = new perfume();

	foreach($_GET as $key => $value){
		if($key != "next"){
			$nkey = "set".ucfirst($key);
			$perfume->$nkey($value);
		}
	}

	$perfume->addToDatabase();

	header('location:'.$_GET['next']);
?>