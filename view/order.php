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

			<div class="company">
				<h2>Company</h2>
				<?php echo($company->getName()); ?>
			</div>
			<div class="employee">
				<h2>Employee</h2>
				<?php echo($employee->getName().' '.$employee->getSurname()); ?>
			</div>
			<div class="form-group">
				
			</div>
			<div class="products">
				<h2>Product</h2>
				<table class="table table-stripped">
					<tr>
						<th>Ref</th>
						<th>Product</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total Price</th>
					</tr>
					<?php
						if(count($order->getline_product()) != 0){
							foreach($order->getline_product() as $line_product){
								print_r($line_product);
							}
						} else {
							echo('<tr><td colspan="5">No product for now</td></tr>');
						}
						
					?>
				</table>
			</div>
			<div class="delete_order">
				<h2>Erase the order <strong>(/!\ CAUTION /!\)</strong></h2>
				<a href="eraseClass.php?next=viewOrders.php&class=order&id=<?php echo($order->getId()); ?>"><button class="btn btn-danger">Delete</button></a>
			</div>
			<?php var_dump($order); ?>
		</div>
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>