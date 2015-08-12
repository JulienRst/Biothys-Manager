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
			<a href="viewAddCompany.php"><button class="btn btn-success"><?php echo($tf->getText(30).' '.$tf->getText(31)); ?></button></a>
		 	<br>
		 	<input id="searchCompany" class="form-control small" type="text">
		 	<br>
			<table class="table table-stripped">
			<tr>
				<th><?php echo($tf->getText(25));?></th>
				<th><?php echo($tf->getText(41));?></th>
				<th><?php echo($tf->getText(42));?></th>
				<th><?php echo($tf->getText(43));?></th>
				<th><?php echo($tf->getText(44));?></th>
				<th><?php echo($tf->getText(45));?></th>
				<th><?php echo($tf->getText(20));?></th>
			</tr>
			<?php
				foreach($companies as $company){
					$company->printTR();
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