<?php

	require_once('../model/group_company.php');
	require_once('../model/error.php');

	$group_company = new group_company();

	if($_GET){
		foreach($_GET as $key => $value){
			if($key != "next"){
				$nattr = "set".ucfirst($key);
				$group_company->$nattr($value);
			}
		}
	}

	try {
		$group_company->addToDatabase();
	} catch(Exception $e){
		echo('Problem at '.$e->getLine().' from controller addGroupCompany :'.$e->getMessage());	
	}

	header('location:'.$_GET["next"]);
?>