<?php
if (isset($_POST['action'])) {
    include '../../cnf/users.php';
    include '../../cnf/mensajes.php';
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'getBuscar':
            $obj =  new Users();
            echo $obj->getBuscar($_POST['dt']);
            break;
        case 'enviar':
            $obj =  new Mensaje();
            echo $obj->Mandar($_POST['dt']);
            break;
        default:
            echo "Opción Inválida";
            break;        
    }
}
