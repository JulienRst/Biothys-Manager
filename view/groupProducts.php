<!DOCTYPE html>
<html>
	<head>
		<title>Biothys Manager - Index</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body> 
		<div class="container">
			<?php include('../view/nav.php'); ?>
			
			

			<a href="viewAddGroupProduct.php"><button class="btn btn-success">Add a group</button></a>
			<h2>List of Group Products</h2>	
			<table class="table table-stripped">
			<tr><th>Name</th><th>Modify</th></tr>
			<?php
				foreach($groups as $group){
					echo('<tr>');
					echo('<td>'.$group->getName().'</td>');
					echo('<td><a href="../controller/viewGroupProduct.php?id='.$group->getId().'"><button><span class=\'glyphicon glyphicon-cog\' aria-hidden=\'true\'></span></button></a></td>');
					echo('</tr>');
				}
			?>
			</table>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>