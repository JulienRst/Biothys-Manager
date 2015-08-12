<?php
	
	//Open the JSON
	$string = file_get_contents("../../assets/text.json");
	$json_a = json_decode($string, true);
	
	//Modify the JSON
		//cas d'un fichier json vide
	if($json_a["text"] == NULL){
		$json_a["text"] = array();
	}
	
	array_push($json_a["text"],array('id' => count($json_a["text"]) +1,'FR' => $_GET['FR'],'EN' => $_GET['EN'],'GER' => $_GET['GER'],'ES' => $_GET['ES']));

	//Save the JSON
	$fp = fopen('../../assets/text.json', 'w');
	fwrite($fp, json_encode($json_a));
	fclose($fp);
	
	//Close and headback to index
	header('location:../index.html');
	exit();

?>