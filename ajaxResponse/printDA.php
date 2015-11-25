<?php
	require_once('../model/link_company_delivery_address.php');
	require_once('../model/address.php');
	require_once('../model/database.php');

	$id_DA = $_GET["idDA"];
	$id_c = $_GET["idC"];

	$pdo = database::getInstance();
	$pdo = $pdo->PDOInstance;

	$stmt = $pdo->prepare('SELECT id FROM link_company_delivery_address WHERE id_company = :idc and id_address = :ida');
	$stmt->bindParam(':idc',$id_c);
	$stmt->bindParam(':ida',$id_DA);

	$stmt->execute();

	$result = $stmt->fetch();
	$idLDA = $result['id'];

	$lda = new link_company_delivery_address($idLDA);

	$address = new address($lda->getId_address());
?>

<h2>Set this Address to Database</h2>
<form method="get" action="../controller/setLinkDA.php">
	<input type="hidden" name="idA" value="<?php echo($address->getId()); ?>">
	<input type="hidden" name="idC" value="<?php echo($id_c); ?>">
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
	<button class="btn btn-success">Set</button>
</form>