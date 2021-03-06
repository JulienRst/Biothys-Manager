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
			<h2><?php echo($tf->getText(12));?></h2>
			<a href="viewAddCustomer.php"><button class="btn btn-success"><?php echo($tf->getText(27).' '.$tf->getText(32));?></button></a>
			<?php 
				echo('<table class="table table-stripped">');
			?>
				<tr>
					<th><?php echo($tf->getText(25));?></th>
					<th><?php echo($tf->getText(31));?></th>
					<th><?php echo($tf->getText(50));?></th>
					<th><?php echo($tf->getText(51));?></th>
					<th><?php echo($tf->getText(45));?></th>
					<th><?php echo($tf->getText(20));?></th>
				</tr>
			<?php
				foreach($customers as $customer){
					$customer->printTR();
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