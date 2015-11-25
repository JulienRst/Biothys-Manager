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
			<a href="viewAddEmployee.php"><button class="btn btn-success"><?php echo($tf->getText(27).' '.$tf->getText(33));?></button></a>
			<br/>
			<br/>
			<div class="input-group">
				<input type="text" id="searchEmployees" class="form-control">
				<span class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
			</div>

			<table class="table table-stripped">
				<tr class="employee">
					<th><?php echo($tf->getText(25));?></th>
					<th><?php echo($tf->getText(53));?></th>
					<th><?php echo($tf->getText(51));?></th>
					<th><?php echo($tf->getText(54));?></th>
					<th><?php echo($tf->getText(45));?></th>
					<th><?php echo($tf->getText(55));?></th>
					<th><?php echo($tf->getText(56));?></th>
					<th><?php echo($tf->getText(57));?></th>
					<th><?php echo($tf->getText(20));?></th>
				</tr>
			<?php 
				foreach($employees as $employee){
					$employee->printTR();
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