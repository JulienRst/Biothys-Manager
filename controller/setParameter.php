<?php
	
	require_once('../model/parameter.php');

	if(isset($_GET["id"])){
		$parameter = new parameter();
		foreach($_GET as $key => $value){
			if($key != "next"){
				$nkey = "set".ucfirst($key);
				$parameter->$nkey($value);
			}
		}
	}

	$parameter->setToDatabase();

	header('location:'.$_GET['next']);

?>