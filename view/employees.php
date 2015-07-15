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
			<a href="viewAddEmployee.php"><button class="btn btn-success">Add Employee</button></a>
			<?php 
				echo('<table class="table table-stripped">');
				echo('<tr><th>Name</th><th>Surname</th><th>Mail</th><th>Short phone</th><th>Phone number</th><th>id_address</th><th>Birthdate</th><th>Right group</th><th>Modify</th></tr>');
				foreach($employees as $employee){
					$employee->printTR();
				}
				echo('</table>');
			?>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>