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
			<h2><?php echo($tf->getText(26).' '.$tf->getText(14));?></h2>
			<a href="viewAddOrder.php"><button class="btn btn-success"><?php echo($tf->getText(30).' '.$tf->getText(14));?></button></a>
			<br/>
			<br/>
			<br/>
			<form method="get" action="viewOrders.php">
				<div class="inline">
					<label for="display">Display</label>
					<select class="form-control short" name="display">
					<?php
						$tab = array('all' => 'All','toprepare' => 'To Prepare','toInvoice' => 'To Invoice','toGetPaid' =>'To get Paid','finished' => 'Finish');
						foreach($tab as $key => $value){
							if($key == $display){
								echo('<option value="'.$key.'" selected>'.$value.'</option>');
							} else {
								echo('<option value="'.$key.'">'.$value.'</option>');
							}
						}
					
					?>
					</select>
					<input type="submit" class="btn btn-success" value="Ok">
				</div>
			</form>
			<br/>
			<table class="table table-stripped">
				<tr>
					<th>Id</th>
					<th><?php echo($tf->getText(31));?></th>
					<th><?php echo($tf->getText(33));?></th>
					<th><?php echo($tf->getText(47));?></th>
					<th><?php echo($tf->getText(37));?></th>
					<th><?php echo($tf->getText(38));?></th>
					<th><?php echo($tf->getText(39));?></th>
					<th><?php echo($tf->getText(82));?></th>
					<th><?php echo($tf->getText(81));?></th>
					<th><?php echo($tf->getText(83));?></th>
					<th><?php echo($tf->getText(20));?></th>
				</tr>
			<?php 
				foreach($orders as $order){
					$order->printTR();
				}
				echo('</table>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>