<?php
if(isset($_POST['action'])){
	header('Content-Type: application/json');
	session_start();
	switch ($_POST['action']) {
		case 'logout':
			session_destroy();
			echo json_encode(array('data' =>true));
		break;
		case 'check':
			if(isset($_SESSION['data']['nickname']))
				echo json_encode(array('data' =>true,'nickname' =>$_SESSION['data']['nickname']));
			else
				echo json_encode(array('data' =>false));
		break;
	}
}