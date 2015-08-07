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
					echo('Rien à afficher');
				} else {
					echo('<h2>You\'re going to modify : '.$employee->getSurname().' '.$employee->getName().'</h2>');
					echo('<form method="get" action="setEmployee.php">');
					$employee->printToModify('viewEmployees.php');
					echo('<button class="btn btn-primary" type="submit">Modify</button>
					</form>');
					echo('<h2>Deleting an employee is irreversible</h2>');
					echo('<a href="eraseEmployee.php?id='.$employee->getId().'""><button class="btn btn-danger">Delete</button></a>');
				}
			?>
		</div>
		<?php include('../view/display.php');?>
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>