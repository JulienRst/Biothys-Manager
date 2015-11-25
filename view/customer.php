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
			
			<h2><?php echo($tf->getText(20));?> : <?php echo($customer->getName());?></h2>
			<form method="get" action="setClass.php">
				<input type="hidden" name="class" value="customer">
				<?php

					$customer->printToModify("viewCustomers.php");

				?>
				<button type="submit" class="btn btn-success"><?php echo($tf->getText(48).' '.$tf->getText(32));?></button>
			</form>
			<h2><?php echo($tf->getText(49));?></h2>
			<?php

				echo('<a href="deleteClass.php?class=customer&id='.$customer->getId().'"><button class="btn btn-danger">'.$tf->getText(22).' '.$tf->getText(32).'</button></a>');

			?>
		</div>
			<?php include('../view/display.php'); ?>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>