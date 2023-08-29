<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}


include_once __DIR__ . "/../conexao.php";


function buscaContratoTipos($idContratoTipo=null)
{
	
	$contratotipo = array();
	
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idContratoTipo' => $idContratoTipo
	);
	$contratotipo = chamaAPI(null, '/services/contratotipos', json_encode($apiEntrada), 'GET');

	//echo json_encode ($contratotipo);
	return $contratotipo;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	if ($operacao=="inserir") {
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContratoTipo' => $_POST['idContratoTipo'],
			'nomeContrato' => $_POST['nomeContrato'],
			'nomeDemanda' => $_POST['nomeDemanda'],
		);

		$contratotipo = chamaAPI(null, '/services/contratotipos', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {

		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContratoTipo' => $_POST['idContratoTipo'],
			'nomeContrato' => $_POST['nomeContrato'],
			'nomeDemanda' => $_POST['nomeDemanda'],
		);
		$contratotipo = chamaAPI(null, '/services/contratotipos', json_encode($apiEntrada), 'POST');

	}
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContratoTipo' => $_POST['idContratoTipo']
		);
		$contratotipo = chamaAPI(null, '/services/contratotipos', json_encode($apiEntrada), 'DELETE');

	}

	header('Location: ../configuracao?stab=contratotipos');
}



?>