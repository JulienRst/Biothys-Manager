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
				<a target="_blank" class="orderPDF"  href="PDFOrderOffer.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default"><?php echo($tf->getText(62));?></button></a>
				<a target="_blank" class="orderPDF" href="PDFOrderConfirmation.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default"><?php echo($tf->getText(63));?></button></a>
				<a target="_blank" class="orderPDF" href="PDFOrderInvoice.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default"><?php echo($tf->getText(64));?></button></a>
				<a target="_blank" class="orderPDF" href="PDFDeliveryOrder.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default"><?php echo($tf->getText(65));?></button></a>
				<a target="_blank" class="orderPDF" href="PDFSamplesInvoice.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default"><?php echo($tf->getText(66));?></button></a>
				<a target="_blank" class="orderPDF" href="PDFSupplies.php?id=<?php echo($order->getId()); ?>"><button class="btn btn-default"><?php echo($tf->getText(67));?></button></a>
			</div>

			<div class="company">
				<h2><?php echo($tf->getText(31));?></h2>
				<?php echo($company->getName()); ?>
			</div>
			<div class="employee">
				<h2><?php echo($tf->getText(33));?></h2>
				<?php echo($employee_->getName().' '.$employee_->getSurname()); ?>
			</div>
			<div class="form-group">
				<label for="billing_period_bis"><h2><?php echo($tf->getText(37));?></h2></label>
				<input type="number" name="billing_period_bis" rel="<?php echo($order->getId()); ?>" class="form-control" value="<?php echo($order->getBilling_period_bis()); ?>">
				<button id="setBillingPeriodBis" class="btn btn-primary"><?php echo($tf->getText(48));?></button>
				<div id="resultSetBpb"></div>
			</div>
			<div class="ctn-order-parameter form-group">
				<label for="line_more"><?php echo($tf->getText(68));?></label>
				<div class="inline">
					<input name="line_more" class="short form-control" type="text" value="<?php echo($order->getCustomer_order_id()); ?>">
					<button rel="<?php echo($order->getId()); ?>" class=" sendLineMore btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
				</div>
				<div id="resultLineMore"></div>
			</div>

			<div class="form-group">
				<label for="id_billing_address"><?php echo($tf->getText(47));?> <?php echo($tf->getText(69));?></label>
				<input type="text" id="delivery_address" class="form-control" value="<?php echo(str_replace('<br/>',' ',$order->getDelivery_address()->printAddress())); ?>">
				<input name="id_billing_address" type="hidden" class="form-control" value="<?php echo($order->getId_delivery_address()); ?>">
				<button id="addAddress" alt="order" step="delivery_address" rel="<?php echo($order->getId()); ?>" class="display btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
				<button id="setAddress" alt="order" step="delivery_address" rel="<?php echo($order->getId()); ?>" class="display btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button></a>
				<button id="getAddress" alt="order" step="delivery_address" rel="<?php echo($order->getId()); ?>" class="display btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
			</div>

			<button id="addProductToOrder" rel="<?php echo($order->getId()); ?>" class="btn btn-success"><?php echo($tf->getText(70));?></button>

			<div class="products">
				<h2> <?php echo($tf->getText(71));?></h2>
				<table class="table table-stripped">
					<tr>
						<th><?php echo($tf->getText(59));?></th>
						<th><?php echo($tf->getText(71));?></th>
						<th><?php echo($tf->getText(72));?></th>
						<th><?php echo($tf->getText(73));?></th>
						<th><?php echo($tf->getText(74));?></th>
						<th><?php echo($tf->getText(75));?></th>
						<th><?php echo($tf->getText(76));?></th>
						<th><?php echo($tf->getText(22));?></th>
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
							echo('<tr><td colspan="5">'.$tf->getText(77).'</td></tr>');
						}
						
					?>
				</table>
				<div>
					<?php echo($tf->getText(78));?> : <?php echo($order->getPrice()); ?>
				</div>
			</div>
			<br/><br/><br/>
			<div class="form-group inline">
				<label for="ready"><?php echo($tf->getText(79));?> : </label>
				<input rel="<?php echo($order->getId()); ?>" type="checkbox" name="ready" <?php if($order->getReady() == "yes"){echo('checked');}?>>
			</div>
			<br/><br/>
			<form method="get" action="setDateOrder.php">
				<input type="hidden" name="id" value="<?php echo($order->getId()); ?>">
				<div class="form-group">
					<label for="date_shipment"><?php echo($tf->getText(81));?></label>
					<input name="date_shipment" class="datepicker form-control short form-date" type="text" value="<?php echo(date('d/m/y',$order->getDate_shipment()));?>">
				</div>
				<div class="form-group">
					<label for="date_receipt"><?php echo($tf->getText(83));?></label>
					<input name="date_receipt" class="datepicker form-control short form-date" type="text" value="<?php echo(date('d/m/y',$order->getDate_receipt()));?>">
				</div>
				<input type="submit" class="btn btn-success" value="<?php echo($tf->getText(20));?>">
			</form>
			<br>
			<br>
			<div class="form-group">
				<label for="already_paid"><?php echo($tf->getText(96)); ?></label>
				<input name="already_paid" type="number" step="0.01" value="<?php echo($order->getAlready_paid());?>"> / <?php echo($order->getFinal_price()); ?><button rel="<?php echo($order->getId()); ?>" class="btn btn-success setAlready_paid"><?php echo($tf->getText(20));?></button>
			</div>	
			<div id="resultAlreadyPaid"></div>
			<br>
			<br>
			<div class="form-group inline">
				<label for="finish"><?php echo($tf->getText(97)); ?> : </label>
				<input rel="<?php echo($order->getId()); ?>" type="checkbox" name="finish" <?php if($order->getFinish() == "yes"){echo('checked');}?>>
			</div>

			<div class="delete_order">
				<h2><?php echo($tf->getText(80));?> <strong>(/!\ CAUTION /!\)</strong></h2>
				<a href="eraseClass.php?next=viewOrders.php&class=order&id=<?php echo($order->getId()); ?>"><button class="btn btn-danger"><?php echo($tf->getText(22));?></button></a>
			</div>
		</div>
		<?php include('../view/display.php'); ?>
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>