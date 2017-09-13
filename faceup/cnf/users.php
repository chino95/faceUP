<?php
require_once('pdocnx.php');

class Users extends ConnectionManager{

	function getBuscar($dt){
        $retval=array('data'=>false,
        'error'=>false,
        'r'=>array(),
        );
    $cnx = $this-> connectMysql();
    try{
        $sth = $cnx->prepare("SELECT ID_Usuario ,Nickname FROM usuarios
        WHERE Nickname LIKE :bu");
        $sth->execute($dt);

        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            $retval['data']=true;
            array_push($retval['r'], array($row['Nickname'],
        '<button class="btn btn-lg btn-dark btn-block " onclick="MostrarModal('.$row['ID_Usuario'].')"data-style="expand-left"><i class="fa fa-paper-plane"></i> Send Nudes</button>'));
      //  <button type="submit" id="btnbusqueda" class="btn btn-lg btn-dark btn-block " data-style="expand-left"><i class="fa fa-paper-plane"></i></button>
        
        }
    }
    catch(PDOException $e){
        $retval['error']=true;
        $retval['r']=$e->getMessage();
    }
    return json_encode($retval);
}

}
?>