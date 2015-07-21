<?php
	$class = $_GET["class"];
	require_once('../model/'.$class.'.php');

	if(isset($_GET["id"])){
		$item = new $class();
		foreach($_GET as $key => $value){
			if($key != "next" && $key != "class"){
				$nkey = "set".ucfirst($key);
				$item->$nkey($value);
			}
		}
	}

	$item->setToDatabase();

	header('location:'.$_GET['next']);

?>