<?php
if(isset($_POST['action'])){
	include '../cnf/usuarios.php';
	include '../classes/localizacion.php';
	header('Content-Type: application/json');
	
	switch ($_POST['action']) {
		case 'login':
		$obj =  new Usuarios();
		echo $obj->login($_POST['dt']);
		break;
		case 'new':
		$obj =  new Usuarios();
		echo $obj->newUsuario($_POST['dt']);
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