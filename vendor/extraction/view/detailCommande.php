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


		<h1>Extraction des données de Biothys Office</h1>
		<form class="form-inline" method="get" action="../controller/viewDetailCommande.php">	
			<div class="form-group">
				<label for="dateBegin">Début : </label>
				<input name="dateBegin" class="datepicker" data-date-format="yyyy-mm-dd">
			</div>
			<div class="form-group">
				<label for="dateEnd">Fin : </label>
				<input name="dateEnd" class="datepicker" data-date-format="yyyy-mm-dd">
			</div>
			<div class="checkbox">
				<label for="display-order-price">
					<input name="display-order-price" type="checkbox"> Afficher chaque montant de facture
				</label>
			</div>
			<br/>
			<div class="form-group">
				<label for="type-of-extract">Quoi extraire : </label>
				<select name="type-of-extract" class="form-control">
					<option value="RE">DE</option>
					<option value="ES">ES</option>
				</select>
			</div>
			<button class="btn btn-success" type="submit">Rechercher</button>
		</form>
			
			<?php 
				if($displayResult){
					echo('<table class="table table-striped table-bordered">');
					echo('<tr><th>Client</th><th>Numero de facture</th><th>Date</th><th>Produit</th><th>Quantite</th><th>Prix unitaire</th><th>Prix total sans transport</th><tr>');

					foreach ($result as $order) {
						foreach($order->getProducts() as $product){
							echo("<tr><td>".$order->getCustomer_name()."</td>");
							echo("<td>".$order->getNumber()."</td>");
							echo("<td>".$order->getDate()."</td>");
							echo("<td>".$product->getName()."</td>");
							echo("<td>".$product->getQuantity()."</td>");
							echo("<td>".str_replace('.',',',$product->getPrice())."</td>");
							echo("<td>".str_replace('.',',',$product->getPrice()*$product->getQuantity())."</td></tr>");
						}
						if($displayOrderPrice){
							echo('<tr><td>Montant de la facture (sans transport) : '.str_replace('.',',',$order->getPrice())."</td>");
							echo('<td>Prix du transport : '.str_replace('.',',',$order->getTransportPrice()).'</td>');
							echo('<td>Montant de la facture (avec transport) : '.str_replace('.',',',$order->getPrice() + $order->getTransportPrice()).'</td></tr>');
						}
					}
					echo('<tr><td>Montant total pour la recherche : '.$extraction->getFinalPrice().'</td>');
					echo('<td>Montant total des transports pour la recherche : '.$extraction->getFinalTransportPrice().'</td></tr>');
					echo("<tr><td>Nombre de facture : ".$extraction->getNbOfOrders()."</td>");
					echo("<td>Prix moyen facture : ".$extraction->getFinalPrice() / $extraction->getNbOfOrders()."</td></tr>");
					echo('</table>');
				}
			?>	
		<script type="text/javascript" src="../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../assets/js/main.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap-datepicker.js"></script>
	</body>
</html>