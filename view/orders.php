<!DOCTYPE html>
<html>
	<head>
		<title>Biothys Manager - Index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body> 
		<div class="container">
			<?php include('../view/nav.php'); ?>
			<h2>List of orders</h2>
			<a href="viewAddOrder.php"><button class="btn btn-success">Add Order</button></a>
			<?php 
				echo('<table class="table table-stripped">');
				echo('<tr><th>Id</th><th>Company</th><th>Employee</th><th>Delivery Address</th><th>Billing Period</th><th>Date issuing</th><th>Date received</th><th>Date shipment</th><th>Date entry</th><th>Date Billing</th><th>Modify</th>');
				foreach($orders as $order){
					$order->printTR();
				}
				echo('</table>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>