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
			<h2>Customers</h2>
			<a href="viewAddCustomer.php"><button class="btn btn-success">Add Customers</button></a>
			<?php 
				echo('<table class="table table-stripped">');
			?>
				<tr><th>Name</th><th>Company</th><th>Nationality</th><th>Mail</th><th>Phone number</th><th>Modify</th></tr>
			<?php
				foreach($customers as $customer){
					$customer->printTR();
				}
				echo('</table>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>