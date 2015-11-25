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
			<h2><?php echo($tf->getText(27).' '.$tf->getText(10));?></h2>
			<form method="get" action="addClass.php">
				<?php
					$gc->printToModify("viewGroupCompanies.php");
				?>
				<button class="btn btn-success" type="submit"><?php echo($tf->getText(27).' '.$tf->getText(10)); ?></button>
			</form>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>