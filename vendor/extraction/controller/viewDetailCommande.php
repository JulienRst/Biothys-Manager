<?php
	
	$displayResult = false;

	if(isset($_GET["dateBegin"]) && (isset($_GET["dateEnd"]))){
		$displayResult = true;
		$displayOrderPrice = false;
		if(isset($_GET["display-order-price"])){$displayOrderPrice = true;}
		$typeOfExtract = $_GET["type-of-extract"];
		require("../model/extraction.php");
		$dateBegin = $_GET["dateBegin"];
		$dateEnd = $_GET["dateEnd"];

		if($typeOfExtract == "ES"){
			$extraction = new extraction($dateBegin,$dateEnd,"FA");
			$result = $extraction->extract();
			$extraction2 = new extraction($dateBegin,$dateEnd,"FA-R");
			$result2 = $extraction2->extract();

			foreach($result2 as $order){
				$order->markAsESRectific();
			}

			$result = array_merge($result,$result2);

			function cmp($a,$b){
				return ($a->getDate() < $b->getDate()) ? -1 : 1;
			}

			usort($result,"cmp");

			$extraction->addToFinalPrice(-($extraction2->getFinalPrice()));



		} else {
			$extraction = new extraction($dateBegin,$dateEnd,$typeOfExtract);
			$result = $extraction->extract();
		}
	}

	include("../view/detailCommande.php");
?>