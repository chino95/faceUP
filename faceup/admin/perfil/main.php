<?php
if(isset($_POST['action'])){
	include '../../cnf/expresiones.php';
	include '../../classes/localizacion.php';
	header('Content-Type: application/json');
	
	switch ($_POST['action']) {
		case 'getExpresionesU':
		$obj =  new Expresion();
		echo $obj->getExpresionesU();
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>