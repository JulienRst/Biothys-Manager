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
			
			<h2><?php echo($tf->getText(20));?> : <?php echo($groupProduct->getName()); ?></h2>
			<form method="get" action="setGroupProduct.php">
				<?php

					$groupProduct->printToModify("viewGroupProducts.php");

				?>
				<button type="submit" class="btn btn-success"><?php echo($tf->getText(48));?> <?php echo($tf->getText(34));?></button>
			</form>
			<h2><?php echo($tf->getText(61));?></h2>
			<?php

				echo('<a href="deleteGroupProduct.php?id='.$groupProduct->getId().'"><button class="btn btn-danger">'.$tf->getText(22).'</button></a>');

			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>