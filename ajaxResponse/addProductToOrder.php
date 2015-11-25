<?php

	require_once('../model/order.php');
	require_once('../model/extraction.php');
	require_once('../model/product.php');

?>

<div class="input-group">
	<label for="product">Name of the product (type and let the machine seek for you)</label>
	<input id="searchProductInOrder" name="product" type="text" class="form-control" placeholder="Product name" aria-describedby="searchProduct">
	<span class="input-group-addon glyphicon glyphicon-search" id="searchProduct"></span>
</div>
<div id="list-product"></div>

<form method="get" action="../controller/addProductToOrder.php">
	<input type="hidden" name="id_order">
	<input type="hidden" name="id_product">
	<div id="parameter_product_add" class="form-group">
		<label for="parameter">Parameter</label>
		<select name="parameter" type="text" class="form-control" value="">

		</select>
	</div>
	<div class="form-group">
		<label for="ref_batch">Ref Batch (n°lot)</label>
		<input name="ref_batch" type="text" class="form-control" value="">
	</div>
	<div class="form-group">
		<label for="quantity">Quantity</label>
		<input name="quantity" type="text" class="form-control" value="1">
	</div>
	<div class="form-group">
		<label for="amount_to_be_delivered">Va être livré</label>
		<input name="amount_to_be_delivered" type="text" class="form-control" value="1">
	</div>
	<div class="form-group">
		<label for="price">Price</label>
		<input name="price" type="text" class="form-control" value="">
	</div>
	<button class="btn btn-success">Add Product</button>
</form>