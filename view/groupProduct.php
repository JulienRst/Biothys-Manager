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
			
			<h2>Modify Group Product : <?php echo($groupProduct->getName()); ?></h2>
			<form method="get" action="setGroupProduct.php">
				<?php

					$groupProduct->printToModify("viewGroupProducts.php");

				?>
				<button type="submit" class="btn btn-success">Set the group</button>
			</form>
			<h2>Delete Group (irreversible)</h2>
			<?php

				echo('<a href="deleteGroupProduct.php?id='.$groupProduct->getId().'"><button class="btn btn-danger">Delete the group</button></a>');

			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>