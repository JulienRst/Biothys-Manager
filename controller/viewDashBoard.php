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

	} else {
		$display = false;
	}


	include('../view/dashBoard.php');
?>