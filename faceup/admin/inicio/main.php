<?php
if(isset($_POST['action'])){
	include '../../cnf/expresiones.php';
	include '../../classes/localizacion.php';
	header('Content-Type: application/json');
	
	switch ($_POST['action']) {
		case 'newExpresion':
		$obj =  new Expresion();
		echo $obj->newExpresion($_POST['dt']);
		break;
		case 'getExpresiones':
		$obj =  new Expresion();
		echo $obj->getExpresiones();
		//echo $obj->getExpresiones($_POST['dt']);
		break;
		case 'getLocalizaciones':
		$obj = new Localizacion();
		echo $obj->getLocalizaciones();
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>