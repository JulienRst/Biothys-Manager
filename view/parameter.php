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
					echo('<h2>'.$tf->getText(19).' : '.$parameter->getName().'</h2>');
					echo('<form method="get" action="setParameter.php">');
					$parameter->printToModify('viewParameters.php');
					echo('<button class="btn btn-primary" type="submit">'.$tf->getText(20).'</button>
					</form>');
					echo('<h2>'.$tf->getText(29).'</h2>');
					echo('<a href="eraseParameter.php?id='.$parameter->getId().'""><button class="btn btn-danger">'.$tf->getText(22).'</button></a>');
				}
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>