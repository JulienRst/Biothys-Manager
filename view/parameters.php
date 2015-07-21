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
			<h2>List of parameters</h2>
			<a href="viewAddParameter.php"><button class="btn btn-success">Add parameters</button></a>
			<?php 
				echo('<table class="table table-stripped">');
				echo('<tr><th>Ref</th><th>Type</th><th>Name</th><th>Modifier</th>');
				foreach($parameters as $parameter){
					$parameter->printTR();
				}
				echo('</table>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>