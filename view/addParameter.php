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
			
			<h2><?php echo($tf->getText(27).' '.$tf->getText(9)); ?></h2>

			<?php
				echo('<form method="get" action="addParameter.php">');
				$parameter->printToModify("viewParameters.php");
				echo('<button class="btn btn-success" type="submit">'.$tf->getText(27).' '.$tf->getText(9).'</button>
				</form>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>