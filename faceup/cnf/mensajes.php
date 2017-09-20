<?php   
require_once('pdocnx.php');

class Mensaje extends ConnectionManager
{
    
    function Mandar($dt){

        try{
			$cnx = $this-> connectMysql();
            session_start();
            $dt['usuario_emi']=$_SESSION['data']['id'];
			$query="INSERT INTO mensajes 
			VALUES (0, :usuario_emi, :usu, :men ,0)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			//$retval['s']=$query;
						if($retval['r']=$sth->rowCount())
				$retval['data']=true;
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
			if($e->getCode() == "23000")
				$retval['r']="Usuario duplicado";
			else
				$retval['r']=$e->getMessage()."  Error Code: ".$e->getCode();
		}
		return json_encode($retval);
        
	}
	
	function Mensajess()
    {
        $retval=array('data'=>false,
        'error'=>false,
        'r'=>array(),
        );
        $cnx = $this-> connectMysql();
        try {
            session_start();
            $uno = $_SESSION['data']['id'];
            $sth = $cnx->prepare("select msj.mensaje,us.Nickname,msj.id_usu_emi from mensajes msj
			inner join usuarios usu on
			usu.ID_Usuario = msj.id_usu_rec
			inner join usuarios us on
			msj.id_usu_emi = us.ID_Usuario
			where id_usu_rec = :usu and msj.visto = '0' ");
            $sth->bindParam(":usu", $uno);               
                $dt['usu']=$uno;
                $sth->execute($dt);

            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                $retval['data']=true;
                array_push($retval['r'], array($row['Nickname'],'<button class="btn btn-lg btn-dark btn-block " onclick="MostrarModal('.$row['id_usu_emi'].')"data-style="expand-left"><i class="fa fa-paper-plane"></i> Responder</button>',
				'<p id="p0">'.$row['mensaje'].'</p>')
			);             
            }
        } catch (PDOException $e) {
            $retval['error']=true;
            $retval['r']=$e->getMessage();
        }
        return json_encode($retval);
    }
}

?>
