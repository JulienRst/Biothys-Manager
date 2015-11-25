<?php
	$displayResult = false;
	if(isset($_GET["dateBegin"]) && (isset($_GET["dateEnd"]))){
		$displayResult = true;

		require('../model/extraction.php');
		$extraction = new extraction($_GET["dateBegin"],$_GET["dateEnd"]);
		$clients = $extraction->extractClient('RE');

		$debDateYear = intval(substr($_GET["dateBegin"],0,4));
		$endDateYear = intval(substr($_GET["dateEnd"],0,4));

		$nbYear = $endDateYear - $debDateYear;
		$debDateMounth = intval(substr($_GET["dateBegin"],5,2));
		$endDateMounth = intval(substr($_GET["dateEnd"],5,2));
		$nbMounth = $endDateMounth - $debDateMounth;

		if($nbYear == 0){
			$nbColumn = $nbMounth;
			$jtab = array(array($debDateMounth,$endDateMounth));
		} else if($nbYear == 1 && $endDateMounth < $debDateMounth){
			$nbColumn = 13 - $debDateMounth + $endDateMounth;
			$jtab = array(array($debDateMounth,12),array(1,$endDateMounth));
		} else {
			$nbColumn = 13 - $debDateMounth + 12*$nbYear + $endDateMounth;
			$jtab = array(array($debDateMounth,12));
			for($i=1;$i<$nbYear;$i++){
				array_push($jtab,array(1,12));
			}
			array_push($jtab,array(1,$endDateMounth));
		}
		$clientsES1 = $extraction->extractClient('FA');
		$clientsES2 = $extraction->extractClient('FA-R');

		foreach ($clientsES2 as $client) {
			$client->markAsRectific();
		}

		

	}


	include("../view/baseClient.php");
?>