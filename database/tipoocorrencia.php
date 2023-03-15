<?php
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// helio 26012023 16:16

include_once('../conexao.php');

function buscaTipoOcorrencia($ocorrenciaInicial=null,$idTipoOcorrencia=null)
{
	
	$tipoocorrencia = array();
	$apiEntrada = array(
		'ocorrenciaInicial' => $ocorrenciaInicial,
		'idTipoOcorrencia' => $idTipoOcorrencia,
	);
	$tipoocorrencia = chamaAPI('tipoocorrencia', 'tipoocorrencia', json_encode($apiEntrada), 'GET');
	return $tipoocorrencia;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'nomeTipoOcorrencia' => $_POST['nomeTipoOcorrencia']
		);
		$tipoocorrencia = chamaAPI('tipoocorrencia', 'tipoocorrencia', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {
		$apiEntrada = array(
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
			'nomeTipoOcorrencia' => $_POST['nomeTipoOcorrencia']
		);
		$tipoocorrencia = chamaAPI('tipoocorrencia', 'tipoocorrencia', json_encode($apiEntrada), 'POST');
	}
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia']
		);
		$tipoocorrencia = chamaAPI('tipoocorrencia', 'tipoocorrencia', json_encode($apiEntrada), 'DELETE');
	}

/*
	include "../cadastros/tipoocorrencia_ok.php";
*/
	header('Location: ../cadastros/tipoocorrencia.php');	
	
}

?>