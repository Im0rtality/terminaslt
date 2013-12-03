<?php
	include("class.Term.php");

	$Obj = new Term();
	$list = $Obj->findAll();
	echo json_encode($list);
?>