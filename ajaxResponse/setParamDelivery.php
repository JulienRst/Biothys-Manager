<?php

	require_once('../model/order.php');

	$order = new order($_GET["id"]);

	$param_delivery = json_decode($order->getParam_delivery(),true);

?>

<h2>Modifier les paramètres de la livraison</h2>
<form method="get" action="../controller/setParamDelivery.php">
	<input type="hidden" name="id" value="<?php echo($order->getId());?>">
	<div class="form-group">
		<label for="DeliveryBy">Délivré par :</label>
		<input name="DeliveryBy" type="text" class="form-control" value="<?php echo($param_delivery['DeliveryBy']);?>">
	</div>
	<div class="form-group">
		<label for="GrossWeight">Poids :</label>
		<input name="GrossWeight" type="text" class="form-control" value="<?php echo($param_delivery['GrossWeight']);?>">
	</div>
	<div class="form-group">
		<label for="NbOfPackages">Nombre d'emballages :</label>
		<input name="NbOfPackages" type="text" class="form-control" value="<?php echo($param_delivery['NbOfPackages']);?>">
	</div>
	<div class="form-group">
		<label for="NbOfPallets">Nombre de palettes :</label>
		<input name="NbOfPallets" type="text" class="form-control" value="<?php echo($param_delivery['NbOfPallets']);?>">
	</div>
	<div class="form-group">
		<label for="Measures">Mesures :</label>
		<input name="Measures" type="text" class="form-control" value="<?php echo($param_delivery['Measures']);?>">
	</div>

	<input type="submit" class="btn btn-success" value="Modifier">

</form>