<!DOCTYPE html>
<html>
	<head>
		<title>Biothys Manager - Index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/datepicker.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body> 
		<?php include('../view/nav.php'); ?>
		<div class="container">
			<?php include('../view/header.php'); ?>
			<h2>Add a new Order</h2>
			<form class="order" method="get" action="addOrder.php">
				<div class="form-group">
					<label for="id_company">Company</label>
					<input name="id_company" type="hidden" value="">
					<input class="form-control" autocomplete="off" name="company" type="text" value="">
					<div id="proposition_company" class="list-group"></div>
				</div>
				<div class="form-group">
					<label for="id_employee">Employee (contact biothys for this order)</label>
					<input name="id_employee" type="hidden" value="">
					<input class="form-control" autocomplete="off" name="employee" type="text" value="">
					<div id="proposition_employee" class="list-group"></div>
				</div>
				<div class="form-group">
					<label for="billing_period_bis">Billing period</label>
					<input class="form-control" autocomplete="off" name="billing_period_bis" type="text" value="">
				</div>

				<div class="ctn-inline">
					<div class="form-group">
						<label for="date_issuing">Date Issuing</label>
						<input name="date_issuing" class="datepicker  form-date" type="text" value="">
					</div>
					<div class="form-group">
						<label for="date_received">Date Received</label>
						<input name="date_received" class="datepicker  form-date" type="text" value="">
					</div>
				</div>



				<button class="btn btn-success" type="submit">Add</button>
			</form>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>