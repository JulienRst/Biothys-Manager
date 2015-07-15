<?php
	require_once('../model/perfume.php');
	require_once('../model/extraction.php');

	$extraction = new extraction();

	$perfumes = $extraction->getPerfumes();

	include('../view/perfumes.php');

?>