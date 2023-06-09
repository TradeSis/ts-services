<?php
// helio 21032023 - compatibilidade chamada chamaApi
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// helio 26012023 16:16

include_once('../conexao.php');

function buscaTipoStatus($statusInicial=null, $idTipoStatus=null)
{
	
	$tipostatus = array();
	$apiEntrada = array(
		'statusInicial' => $statusInicial,
		'idTipoStatus' => $idTipoStatus,
	);
	$tipostatus = chamaAPI(null, '/services/tipostatus', json_encode($apiEntrada), 'GET');
	return $tipostatus;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'nomeTipoStatus' => $_POST['nomeTipoStatus'],
			'mudaPosicaoPara' => $_POST['mudaPosicaoPara'],
			'mudaStatusPara' => $_POST['mudaStatusPara']
		);
		$tipostatus = chamaAPI(null, '/services/tipostatus', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {
		$apiEntrada = array(
			'idTipoStatus' => $_POST['idTipoStatus'],
			'nomeTipoStatus' => $_POST['nomeTipoStatus'],
			'mudaPosicaoPara' => $_POST['mudaPosicaoPara'],
			'mudaStatusPara' => $_POST['mudaStatusPara']
		);
		$tipostatus = chamaAPI(null, '/services/tipostatus', json_encode($apiEntrada), 'POST');
	}
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idTipoStatus' => $_POST['idTipoStatus']
		);
		$tipostatus = chamaAPI(null, '/services/tipostatus', json_encode($apiEntrada), 'DELETE');
	}

/*
	include "../cadastros/tipostatus_ok.php";
*/
	header('Location: ../cadastros/tipostatus.php');	
	
}
