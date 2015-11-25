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
			<?php
				if(isset($error)){
					echo($tf->getText(18));
				} else {
					echo('<h2>'.$tf->getText(19).' '.$employee->getSurname().' '.$employee->getName().'</h2>');
					echo('<form method="get" action="setEmployee.php">');
					$employee->printToModify('viewEmployees.php');
					echo('<button class="btn btn-primary" type="submit">'.$tf->getText(20).'</button>
					</form>');
					echo('<h2>'.$tf->getText(52).'</h2>');
					echo('<a href="eraseEmployee.php?id='.$employee->getId().'""><button class="btn btn-danger">'.$tf->getText(22).'</button></a>');
				}
			?>

			<h2>Précédentes Commandes</h2>

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
		<?php include('../view/display.php');?>
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>