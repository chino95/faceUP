<?php
if (isset($_POST['action'])) {
    include '../../cnf/mensajes.php';
    header('Content-Type: application/json');    
    switch ($_POST['action']) {
        case 'enviar':
            $obj =  new Mensaje();
            echo $obj->Mandar($_POST['dt']);
            break;
        case 'Mensaje':
        $obj =  new Mensaje();
        echo $obj->Mensajess();
        break;       
        default:
            echo "Opción Inválida";
            break;        
    }
}
