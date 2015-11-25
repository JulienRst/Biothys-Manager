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
			<a href="viewAddPartner.php"><button class="btn btn-success"><?php echo($tf->getText(27).' '.$tf->getText(40));?></button></a>
			<table class="table table-stripped">
				<tr>
					<th><?php echo($tf->getText(84));?></th>
					<th><?php echo($tf->getText(59));?></th>
					<th><?php echo($tf->getText(20));?></th>
				</tr>
			<?php 	
				foreach($partners as $partner){
					$partner->printTR();
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