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
				<form class="form-inline" method="get" action="viewMonitoring.php">
					<div class="form-group block">
						<label for="dateDeb">Date début :</label>
						<input name="dateDeb" data-date-format="dd-mm-yy" class="datepicker" value="<?php if(isset($_GET['dateDeb'])){echo($_GET['dateDeb']);} ?>">
					</div>
					<div class="form-group block">
						<label for="dateEnd">Date fin :</label>
						<input name="dateEnd" data-date-format="dd-mm-yy" class="datepicker" value="<?php if(isset($_GET['dateEnd'])){echo($_GET['dateEnd']);} ?>">
					</div>
					<input type="submit" class="btn btn-primary">
			</form>
			<div>
			The current years turnover is : <?php echo($yearTurnover);?>€<br>
			The current month turnover is : <?php echo($monthTurnover);?>€<br>

			<?php 
				if($display){
			?>

				<ul class="nav monitoring nav-tabs">
					<li role="mainview" class="active"><a href="#">Vue Générale</a></li>
					<li role="products"><a href="#">Produits</a></li>
					<li role="mapping"><a href="#">Cartographie</a></li>
					<li role="encoursclient"><a href="#">En cours client</a></li>
				</ul>
				<div class="tabs">
					<div rel="mainview" class="active subpanel">
						<table class="table table-stripped">
							<tr>
								<th>Name of Company</th>
								<?php
									foreach ($columns as $key => $value) {
										echo('<th>'.$key.'</th>');
									}
								?>
								<th>Total</th>
							</tr>
							<?php
								foreach($companies as $company){
									echo('<tr>');
									echo('<td>'.$company->getName().'</td>');
									$summ = 0;
									foreach($columns as $key => $value){
										if(isset($company->getOrdersMonth()[$key])){
											echo('<td>'.number_format($company->getOrdersMonth()[$key],2,',',' ').' €</td>');
											$summ += $company->getOrdersMonth()[$key];
										} else {
											echo('<td></td>');
										}
									}

									echo('<td>'.number_format($summ,2,',',' ').' €</td>');
									echo('</tr>');

								}
								echo('<tr>');
									echo('<td>Total : </td>');
									$max_summ = 0;
									foreach($final_line as $key => $value){
										$max_summ += $value;
										echo("<td>".number_format($value,2,',',' ').' €</td>');
									}
									echo('<td>'.number_format($max_summ,2,',',' ').' €</td>');
								echo('</tr>');
							?>
						</table>
						<?php if($displayOld){ ?>

						<div class="alert alert-warning alert-dismissible" role="alert">
 							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  							<strong>Warning!</strong> This export content values of the old database
						</div>



						<?php } ?>

					</div>
					<div rel="products" class="subpanel">
						<!-- group_product["group"]["country"]["name"]["date"]{["quantity"]["pricetotal"]} -->

						<?php 

							foreach($group_products as $name_gp => $countries){
								echo('<h2>'.$name_gp.'</h2>');
								foreach($countries as $name_c => $products){
									echo('<h3>'.$name_c.'</h3>');
								
						?>
									<table class="table table-bordered">
										<tr>
											<th rowspan="2" style="text-align:center; vertical-align:middle;">Name of Product</th>
											<?php
											foreach ($columns as $key => $value) {
												echo('<th colspan="2" style="text-align:center;">'.$key.'</th>');
											}
											?>
										</tr>
										<tr>
											<?php
												for($i=0;$i<count($columns)*2;$i++){
													if($i%2 == 0){
														echo('<th style="text-align:center;">Quantity</th>');
													} else {
														echo('<th style="text-align:center;">Price</th>');
													}
												}
											?>
										</tr>
										<?php
											foreach($products as $name => $dates){
												echo('<tr>');
												echo('<td style="text-align:center;">'.$name.'</td>');
												foreach($columns as $date => $nothingusable){
													if(isset($dates[str_replace('-', '/', $date)])){
														$display = $dates[str_replace('-', '/', $date)];
														echo('<td style="text-align:center;">'.$display["quantity"].'</td><td style="text-align:center;">'.number_format($display["price"],2,',',' ').' €</td>');
													} else {
														echo('<td></td><td></td>');
													}
												}
												echo('</tr>');
											}
										?>
									</table>
						<?php
								}
							}

						?>





					</div>
					<div rel="mapping" class="subpanel">
						<?php 
							foreach($tab_country_company as $tag => $value){
								echo('<h2>'.$tag.'</h2>');
								foreach($value as $company){
						?>
									<table class="table table-stripped">
										<tr>
											<th>Name of Company</th>
											<?php
												foreach ($columns as $key => $value) {
													echo('<th>'.$key.'</th>');
												}
											?>
											<th>Total</th>
										</tr>
								
								<?php
									echo('<tr>');
									echo('<td>'.$company->getName().'</td>');
									$summ = 0;
									foreach($columns as $key => $value){
										if(isset($company->getOrdersMonth()[$key])){
											echo('<td>'.number_format($company->getOrdersMonth()[$key],2,',',' ').' €</td>');
											$summ += $company->getOrdersMonth()[$key];
										} else {
											echo('<td></td>');
										}
									}

									echo('<td>'.number_format($summ,2,',',' ').' €</td>');
									echo('</tr>');
									echo('<tr>');
										echo('<td>Total</td>');
										$summmum = 0;
											foreach($final_line_country[$tag] as $date => $value){
											echo('<td>'.number_format($value,2,',',' ').' €</td>');
											$summmum += $value;
										}
										echo('<td>'.number_format($summmum,2,',',' ').' €</td>');
									echo('</tr>');
								?>
									</table>
						<?php 
								}
							}
						?>



					</div>
					<div rel="encoursclient" class="subpanel">

						<table class="table">
							<tr>
								<th>Customer</th>
								<th>Employee</th>
								<th>Invoice</th>
								<th>Can pay until</th>
								<th>Already Paid</th>
								<th>Have to pay</th>
								<th>Go to order</th>
							</tr>
							<?php

								foreach($ordersToGetPaid as $order){
									//Calcul de la date de paiement
									$dateBilling = $order->getDate_receipt();
									$billing_period = $order->getBilling_period_bis();

									$sdateBilling = gmdate('d-m-y',$dateBilling);
									$sdatePaid = gmdate('d-m-y',$dateBilling + intval($billing_period)*24*3600);
									$today = date('today');
									$today = strtotime($today);



									$customer = new company($order->getId_company());
									$employee = $order->getEmployee();
									if($dateBilling == 0){
										echo('<tr class="success">');
									} else if($today < $dateBilling + intval($billing_period)*24*3600){
										echo('<tr class="warning">');
									} else {
										echo('<tr class="danger">');
									}
										echo('<td>'.$customer->getName().'</td>');
										echo('<td>'.$employee->printLink().'</td>');
										if($dateBilling != 0){
											echo('<td>'.$sdateBilling.'</td>');
											echo('<td>'.$sdatePaid.'</td>');
										} else {
											echo('<td>Pas encore renseigné</td>');
											echo('<td>Pas encore renseigné</td>');
										}
										echo('<td>'.number_format($order->getAlready_paid(),2,',',' ').' €</td>');
										echo('<td>'.number_format($order->getPrice(),2,',',' ').' €</td>');
										echo('<td><a href="viewOrder.php?id='.$order->getId().'"><button class="btn btn-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button></a></td>');

									echo('</tr>');
								}

							?>

						</table>

					</div>
				</div>

				
			<?php
				}
			?>

			</div>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>