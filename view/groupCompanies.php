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
			
			

			<a href="viewAddGroupCompany.php"><button class="btn btn-success">Add a group company</button></a>
			<h2>List of Group Company</h2>	
			<table class="table table-stripped">
			<tr><th>Ref</th><th>Designation</th><th>Modify</th></tr>
			<?php
				foreach($group_companies as $group_company){
					$group_company->printTR();
				}
			?>
			</table>
		</div>

		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
	</body>
</html>