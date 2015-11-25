<?php
	require_once('../model/address.php');
	$data = $_GET["address"];
	$data = json_decode($data,true);
	$address = new address($data["id"]);
?>

<h2>Set this Address to Database</h2>
<form class="setAddresstodb">
	<div class="form-group">
		<label for="line">Line</label>
		<input type="text" class="form-control" name="line" value="<?php echo($address->getLine()); ?>"/>
	</div>
	<div class="form-group">
		<label for="complement">Complement</label>
		<input type="text" class="form-control" name="complement" value="<?php echo($address->getComplement()); ?>"/>
	</div>
	<div class="form-group">
		<label for="zip">Zip</label>
		<input type="text" class="form-control" name="zip" value="<?php echo($address->getZip()); ?>"/>
	</div>
	<div class="form-group">
		<label for="city">City</label>
		<input type="text" class="form-control" name="city" value="<?php echo($address->getCity()); ?>"/>
	</div>
	<div class="form-group">
		<label for="state">State</label>
		<input type="text" class="form-control" name="state" value="<?php echo($address->getState()); ?>"/>
	</div>
	<div class="form-group">
		<label for="country">Country</label>
		<input type="text" class="form-control" name="country" value="<?php echo($address->getCountry()); ?>"/>
	</div>
	<input type="hidden" name="id" value="<?php echo($data['id']); ?>" />
	<input type="hidden" name="class" value="<?php echo($data['for']); ?>" />
	<input type="hidden" name="step" value="<?php echo($data['step']); ?>" />
	
	<button class="setAddress btn btn-success">Set</button>
</form>