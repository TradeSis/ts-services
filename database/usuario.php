<?php
// helio 21032023 - compatibilidade chamada chamaApi
// Lucas 08032023 alterado buscaUsuarios(nomeUsuario=null) para buscaUsuarios($idUsuario=null)
// gabriel 06022023 adicionado função busca atendente
// helio 01022023 consertado operacao inserir
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// helio 26012023 16:16

include_once('../conexao.php');

function buscaUsuarios($idUsuario=null)
{

	$usuario = array();
	 //echo json_encode($idUsuario);
	//return;	
	$apiEntrada = array(
		'idUsuario' => $idUsuario,
	);
	 

	
	//echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	//return;	
	$usuario = chamaAPI(null, '/api/services/usuario', json_encode($apiEntrada), 'GET');
	// echo json_encode($usuario);
	return $usuario;
}

function buscaAtendente($idUsuario=null)
{

	$atendente = array();
	$apiEntrada = array(
		'idUsuario' => $idUsuario,
	);
	
	$atendente = chamaAPI(null, '/api/services/atendente', json_encode($apiEntrada), 'GET');
	return $atendente;
}



if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$apiEntrada = array(
			/* 'idCliente' => $_POST['idCliente'],
			'nomeUsuario' => $_POST['nomeUsuario'],
			'email' => $_POST['email'],
			'password' => $_POST['password']
 */
			'nomeUsuario' => $_POST['nomeUsuario'],
			//'idCliente' => $_POST['idCliente'],
			'email' => $_POST['email'],
			'password' => md5 ($_POST['password'])
			
		);
		/*  echo json_encode($_POST);
		echo "\n";
		echo json_encode($apiEntrada);
		return;  */
		$usuario = chamaAPI(null, '/api/services/usuario', json_encode($apiEntrada), 'PUT');
		
	}

	if ($operacao == "alterar") {
		
		$apiEntrada = array(
			'idUsuario' => $_POST['idUsuario'],
			//'idCliente' => $_POST['idCliente'],
			'nomeUsuario' => $_POST['nomeUsuario'],
			'email' => $_POST['email'],
			'password' => md5 ($_POST['password'])
		);
		//echo json_encode($_POST);
		//echo "\n";
		//echo json_encode($apiEntrada);
		//return;
		
		$usuario = chamaAPI(null, '/api/services/usuario', json_encode($apiEntrada), 'POST');
	}


	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idUsuario' => $_POST['idUsuario']
		);
		$usuario = chamaAPI(null, '/api/services/usuario', json_encode($apiEntrada), 'DELETE');
	}



/*
	include "../usuario/usuario_ok.php";
*/
	header('Location: ../usuario/usuario.php');
}
