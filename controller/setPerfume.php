<?php
	
	require_once('../model/perfume.php');

	if(isset($_GET["id"])){
		$perfume = new perfume();
		foreach($_GET as $key => $value){
			if($key != "next"){
				$nkey = "set".ucfirst($key);
				$perfume->$nkey($value);
			}
		}
	}

	$perfume->setToDatabase();

	header('location:'.$_GET['next']);

?>