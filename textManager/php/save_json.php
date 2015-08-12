<?php
	
	//Open the JSON
	$string = file_get_contents("../../assets/text.json");
	$json_a = json_decode($string, true);
	
	//Modify the JSON
	for($i=0;$i<count($json_a["text"]);$i++){
		if($json_a["text"][$i]["id"] == $_GET["id"]){
			foreach ($json_a["text"][$i] as $key => $value) {
				$json_a["text"][$i][$key] = $_GET[$key];
			}
			break;
		}
	}

	//Save the JSON
	$fp = fopen('../../assets/text.json', 'w');
	fwrite($fp, json_encode($json_a));
	fclose($fp);
	
	//Close and headback to index
	header('location:../index.html');
	exit();
?>