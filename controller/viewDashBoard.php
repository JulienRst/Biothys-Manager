<?php
	require_once('checkSession.php');
	require_once('../model/employee.php');
	require_once('../model/extraction.php');

	if(isset($_GET["dateDeb"]) && $_GET["dateDeb"] != "" && isset($_GET["dateEnd"]) && $_GET["dateEnd"] != ""){
		$display = true;
		$deb = $_GET["dateDeb"];
		$end = $_GET["dateEnd"];
		$id_e = $_SESSION["employee"];
		$employee = new employee($id_e);

		$extraction = new extraction();

		$orders = $extraction->getOrdersFromEmployeeWithDate($id_e,$deb,$end);

		$ca = 0;
		$count = count($orders);
		foreach($orders as $order){
			$ca += $order->getPrice();
		}

		$ca = number_format($ca,2,',',' ');

		//On regroupe les commandes par leur client
		$companies = array();

		function search($id,$company){
			$mag = false;
			foreach($company as $i => $item){
				if($item->getId() == $id){
					$mag = $i;
				}
			}
			return $mag;
		}

		foreach($orders as $order){
			$tag = search($order->getId_company(),$companies);
			if($tag !== false){
				$companies[$tag]->addOrder($order);
			} else {
				$new_company = new company($order->getId_company());
				$new_company->addOrder($order);
				array_push($companies,$new_company);
			}
		}


	} else {
		$display = false;
	}


	include('../view/dashBoard.php');
?>