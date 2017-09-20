<?php
require_once('pdocnx.php');

class Usuarios extends ConnectionManager{

	public function login($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');
		$cnx = $this-> connectMysql();
		$dt['psw'] = hash('sha256', $dt['psw']);
		try{
			$sth = $cnx->prepare("SELECT ID_Usuario, Psw, Nickname, ID_Localizacion FROM usuarios WHERE correo=:usr AND Psw=:psw");
			$sth->execute($dt);
			if($row = $sth->fetch(PDO::FETCH_ASSOC)){
					session_start();
					$_SESSION['data'] = array('id'=> $row['ID_Usuario'],'nickname'=> $row['Nickname'], 'localizacion'=>$row['ID_Localizacion']);
					$retval['data']=true;
					$retval['r']=$_SESSION['data'];
			}
			else{
				$retval['r']="Usuario o Contraseña Incorrectos";
				$retval['error']=true;
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}
	public function newUsuario($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$dt["psw"]=hash('sha256', $dt['psw']);

		try{
			$query="INSERT INTO usuarios (Nickname, Correo, Psw, ID_Localizacion) 
			VALUES (:nick, :cor, :psw, :loc)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			$retval['s']=$query;
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

	function getUsuario(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Usuario'),array('title'=>'Nombre'),array('title'=>'Status'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT id_user, nombre, username, status FROM users ");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				$status = $row['status'] == 1 ? '<span class="label label-sm label-success"> Activo </span>' : '<span class="label label-sm label-danger"> Inactivo </span>';

				array_push($retval['r'], array($row['id_user'], $row['username'], $row['nombre'], $status,
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['id_user'].')">Modificar</button>'));
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