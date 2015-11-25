<?php

	require_once('../model/order.php');
	require_once('../model/extraction.php');
	require_once('../model/product.php');
	require_once('../model/link_order_product.php');

	$lop = new link_order_product($_GET["id"]);

?>

<div class="input-group">
	<label for="product">Name of the product (type and let the machine seek for you)</label>
	<input id="searchProductInOrder" name="product" type="text" class="form-control" placeholder="Product name" value="<?php echo($lop->getProduct()->getName()); ?>" aria-describedby="searchProduct">
	<span class="input-group-addon glyphicon glyphicon-search" id="searchProduct"></span>
</div>
<div id="list-product"></div>

<form method="get" action="../controller/setLineProductToOrder.php">
	<input type="hidden" name="id_link_order" value="<?php echo($lop->getId());?>">
	<input type="hidden" name="id_product" value="<?php echo($lop->getId_product());?>">
	<div id="parameter_product_add" class="form-group">
		<label for="parameter">Parameter</label>
		<select name="parameter" type="text" class="form-control">
			<!-- Rajouter les options en fonctions du type etc... -->
		</select>
	</div>
	<div class="form-group">
		<label for="ref_batch">Ref Batch (n°lot)</label>
		<input name="ref_batch" type="text" class="form-control" value="<?php echo($lop->getRef_batch());?>">
	</div>
	<div class="form-group">
		<label for="quantity">Quantity</label>
		<input name="quantity" type="text" class="form-control" value="<?php echo($lop->getAmount());?>">
	</div>
	<div class="form-group">
		<label for="amount_already_delivered">Déjà livré + en cours</label>
		<input name="amount_already_delivered" type="text" class="form-control" value="<?php echo($lop->getAmount_already_delivered()); ?>">
	</div>
	<div class="form-group">
		<label for="amount_to_be_delivered">En cours</label>
		<input name="amount_to_be_delivered" type="text" class="form-control" value="<?php echo($lop->getAmount_to_be_delivered()); ?>">
	</div>
	<div class="form-group">
		<label for="price">Price<span id="unity"></span></label>
		<input name="price" type="text" class="form-control" value="<?php echo($lop->getPrice_bis());?>">
	</div>
	<button class="btn btn-success">Set Line Order</button>
</form>