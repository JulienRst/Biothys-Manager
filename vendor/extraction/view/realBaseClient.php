<!DOCTYPE html>
<html>
	<head>
		<title>Biothys | Extraction</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/datepicker.css">
	</head>
	<body>


		<h1>Extraction des données de Biothys Office : Base de données Clients</h1>
		<?php 
				echo('<table class="table table-striped table-bordered">');
				echo('<tr><th>ID</th><th>Client</th><th>Mail</th><th>CODE PAYS</th><th>nb de commande</th><th>total dépensé</th><tr>');

				foreach ($clients as $client) {
					echo('<tr>');
					echo('<td>'.$client->getId().'</td>');
					echo('<td>'.$client->getName().'</td>');
					echo('<td>'.$client->getMail().'</td>');
					echo('<td>'.$client->getCC().'</td>');
					echo('<td>'.$client->getNbOrders().'</td>');
					echo('<td>'.$client->getAmount().'</td>');
					echo('</tr>');
				}
				echo('</table>');
		?>	
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap-datepicker.js"></script>
	</body>
</html>