<?php
	$class = $_GET["class"];
	require_once('../model/'.$class.'.php');
	require_once('../model/error.php');

	$item = new $class();

	if($_GET){
		foreach($_GET as $key => $value){
			if($key != "next" && $key != "class"){
				$nattr = "set".ucfirst($key);
				$item->$nattr($value);
			}
		}
	}

	$item->addToDatabase();

	if($_GET["next"] != "no"){
		header('location:'.$_GET["next"]);
	}
?>