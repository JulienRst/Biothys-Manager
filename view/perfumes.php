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
			<h2>List of perfumes</h2>
			<a href="viewAddPerfume.php"><button class="btn btn-success">Add Perfumes</button></a>
			<?php 
				echo('<table class="table table-stripped">');
				echo('<tr><th>Ref</th><th>Name</th><th>Modifier</th>');
				foreach($perfumes as $perfume){
					$perfume->printTR();
				}
				echo('</table>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>