<?php
// helio 21032023 - compatibilidade chamada chamaApi
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// helio 26012023 16:16

include_once __DIR__ . "/../conexao.php";

function buscaTipoOcorrencia($ocorrenciaInicial=null,$idTipoOcorrencia=null)
{
	
	$tipoocorrencia = array();
	$apiEntrada = array(
		'ocorrenciaInicial' => $ocorrenciaInicial,
		'idTipoOcorrencia' => $idTipoOcorrencia,
	);
	$tipoocorrencia = chamaAPI(null, '/services/tipoocorrencia', json_encode($apiEntrada), 'GET');
	return $tipoocorrencia;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'nomeTipoOcorrencia' => $_POST['nomeTipoOcorrencia']
		);
		$tipoocorrencia = chamaAPI(null, '/services/tipoocorrencia', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {
		$apiEntrada = array(
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
			'nomeTipoOcorrencia' => $_POST['nomeTipoOcorrencia']
		);
		$tipoocorrencia = chamaAPI(null, '/services/tipoocorrencia', json_encode($apiEntrada), 'POST');
	}
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia']
		);
		$tipoocorrencia = chamaAPI(null, '/services/tipoocorrencia', json_encode($apiEntrada), 'DELETE');
	}

/*
	include "../configuracao/tipoocorrencia_ok.php";
*/
	header('Location: ../configuracao?stab=tipoocorrencia');
	
}

?>