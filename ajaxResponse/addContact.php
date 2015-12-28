<?php

    require('../model/customer.php');

    $new_customer = new customer();

    $getobject = json_decode($_GET['address']);
?>

    <form method="get" action="addCustomerInCompanyAsContact.php">
        <input type="hidden" name="id_company" value="<?php echo($getobject->idFor);?>">
    <?php $new_customer->printToAdd(""); ?>
        <button class="btn btn-primary">Ajouter</button>
    </form>
