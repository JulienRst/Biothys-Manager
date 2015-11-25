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
			
			

			<a href="viewAddGroupProduct.php"><button class="btn btn-success"><?php echo($tf->getText(27).' '.$tf->getText(8));?></button></a>
			<h2><?php echo($tf->getText(26).' '.$tf->getText(8));?></h2>	
			<table class="table table-stripped">
			<tr><th><?php echo($tf->getText(25));?></th><th><?php echo($tf->getText(28));?></th><th><?php echo($tf->getText(20));?></th></tr>
			<?php
				foreach($groups as $group){
					echo('<tr>');
					echo('<td>'.$group->getName().'</td>');
					echo('<td>'.$group->getType().'</td>');
					echo('<td><a href="../controller/viewGroupProduct.php?id='.$group->getId().'"><button><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td>');
					echo('</tr>');
				}
			?>
			</table>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/datepicker.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>