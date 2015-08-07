<!DOCTYPE html>
<html>
	<head>
		<title>Biothys Manager - Index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body> 
		<?php include('../view/nav.php'); ?>
		<div class="container">
			<?php include('../view/header.php'); ?>


			<div class="document inline">
				<a target="_blank" class="orderPDF"  href="PDFOrderOffer.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default">Make an Offer</button></a>
				<a target="_blank" class="orderPDF" href="PDFOrderConfirmation.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default">Order Confirmation</button></a>
			</div>

			<div class="company">
				<h2>Company</h2>
				<?php echo($company->getName()); ?>
			</div>
			<div class="employee">
				<h2>Employee</h2>
				<?php echo($employee_->getName().' '.$employee_->getSurname()); ?>
			</div>
			<div class="form-group">
				<label for="billing_period_bis"><h2>Billing Period</h2></label>
				<input type="number" name="billing_period_bis" rel="<?php echo($order->getId()); ?>" class="form-control" value="<?php echo($order->getBilling_period_bis()); ?>">
				<button id="setBillingPeriodBis" class="btn btn-primary">Set</button>
				<div id="resultSetBpb"></div>
			</div>
			<div class="ctn-order-parameter form-group">
				<label for="line_more">id order for the customer</label>
				<div class="inline">
					<input name="line_more" class="short form-control" type="text" value="<?php echo($order->getCustomer_order_id()); ?>">
					<button rel="<?php echo($order->getId()); ?>" class=" sendLineMore btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				</div>
				<div id="resultLineMore"></div>
			</div>

			<div class="form-group">
				<label for="id_billing_address">Delivery Address (add or set the address with the button bellow not the textarea)</label>
				<input type="text" id="delivery_address" class="form-control" value="<?php echo(str_replace('<br/>',' ',$order->getDelivery_address()->printAddress())); ?>">
				<input name="id_billing_address" type="hidden" class="form-control" value="<?php echo($order->getId_delivery_address()); ?>">
				<button id="addAddress" alt="order" step="delivery_address" rel="<?php echo($order->getId()); ?>" class="display btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
				<button id="setAddress" alt="order" step="delivery_address" rel="<?php echo($order->getId()); ?>" class="display btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button></a>
				<button id="getAddress" alt="order" step="delivery_address" rel="<?php echo($order->getId()); ?>" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
			</div>

			<button id="addProductToOrder" rel="<?php echo($order->getId()); ?>" class="btn btn-success">Add a product to the order</button>

			<div class="products">
				<h2>Product</h2>
				<table class="table table-stripped">
					<tr>
						<th>Ref</th>
						<th>Product</th>
						<th>Parameter</th>
						<th>Ref batch</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total Price</th>
						<th>Delete</th>
					</tr>
					<?php
						if(count($order->getline_product()) != 0){
							
							foreach($order->getline_product() as $line_product){
								echo('<tr>');
								$product = $line_product->getProduct();
								$parameter = $line_product->getParameter();
								echo('<td>'.$line_product->getRef().'</td>');
								echo('<td>'.$product->getName().'</td>');
								echo('<td>'.$parameter->getName().'</td>');
								echo('<td>'.$line_product->getRef_batch().'</td>');
								echo('<td>'.$line_product->getAmount().'</td>');
								echo('<td>'.$line_product->getPrice_bis().'</td>');
								echo('<td>'.$line_product->getPrice_bis() * $line_product->getAmount().'</td>');
								echo('<td><a href="eraseClass.php?class=link_order_product&id='.$line_product->getId().'&next=viewOrder.php?id='.$order->getId().'"><button class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a></td>');
								echo('</tr>');
							}
						} else {
							echo('<tr><td colspan="5">No product for now</td></tr>');
						}
						
					?>
				</table>
				<div>
					Final price of the order : <?php echo($order->getPrice()); ?>
				</div>
			</div>
			<br/><br/>
			<div class="form-group inline">
				<label for="ready">Order is ready : </label>
				<input rel="<?php echo($order->getId()); ?>" type="checkbox" name="ready" <?php if($order->getReady() == "yes"){echo('checked');}?>>
			</div>

			<div class="delete_order">
				<h2>Erase the order <strong>(/!\ CAUTION /!\)</strong></h2>
				<a href="eraseClass.php?next=viewOrders.php&class=order&id=<?php echo($order->getId()); ?>"><button class="btn btn-danger">Delete</button></a>
			</div>
		</div>
		<?php include('../view/display.php'); ?>
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>