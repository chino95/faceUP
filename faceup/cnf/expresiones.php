<?php
require_once('pdocnx.php');

class Expresion extends ConnectionManager{

	public function newExpresion($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
        $dt['fec']=date('Y/m/d'); 
        session_start();
        $dt['id']=$_SESSION['data']['id'];
		try{
			$query="INSERT INTO expresiones (ID_Usuario, Contenido, Duracion) 
			VALUES (:id, :ex, :fec)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			$retval['s']=$query;
			if($retval['r']=$sth->rowCount())
				$retval['data']=true;
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	function getExpresiones($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			);
			$fechaa=date('Y/m/d'); 
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT u.Nickname, e.Contenido, e.Duracion FROM expresiones e
			INNER JOIN usuarios u ON e.ID_Usuario = u.ID_Usuario
			WHERE e.Duracion = :fec && u.ID_Localizacion = :ubi");
			  $sth->bindParam(':fec', $fechaa);
			  $sth->bindParam(':ubi', $dt);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['Nickname'], $row['Contenido'], $row['Duracion']));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

function getModalUsuarios($id){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT id_user, nombre, username, status FROM users WHERE id_user = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'],  
				$row['nombre'], 
				$row['username'],
				$row['status']
				);
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}


	public function updateUsuario($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');
		$obj = new ConnectionManager();
		$cnx = $obj-> connectMysql();
		$dt["psw"]=hash('sha256', $dt['psw']);
		try{
			$query="UPDATE users SET nombre =:nom, username=:usr, psw=:psw, status=:st WHERE id_user = :id";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			$retval['s']=$query;
			if($retval['r']=$sth->rowCount())
				$retval['data']=true;
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}
}
?>