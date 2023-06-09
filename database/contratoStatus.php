<?php
// helio 21032023 - compatibilidade chamada chamaApi
// helio 01022023 altereado para include_once, usando funcao conectaMysql

include_once('../conexao.php');


function buscaContratoStatus($idContratoStatus=null)
{
	
	$contratoStatus = array();
	
	$apiEntrada = array(
		'idContratoStatus' => $idContratoStatus,
	);
	$contratoStatus = chamaAPI(null, '/services/contratostatus', json_encode($apiEntrada), 'GET');

	//echo json_encode ($contratoStatus);
	return $contratoStatus;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'nomeContratoStatus' => $_POST['nomeContratoStatus'],
			'mudaStatusPara' => $_POST['mudaStatusPara']
		);
		
		$contratoStatus = chamaAPI(null, '/services/contratostatus', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {

		$apiEntrada = array(
			'idContratoStatus' => $_POST['idContratoStatus'],
			'nomeContratoStatus' => $_POST['nomeContratoStatus'],
			'mudaStatusPara' => $_POST['mudaStatusPara']
		);
		$contratoStatus = chamaAPI(null, '/services/contratostatus', json_encode($apiEntrada), 'POST');

	}
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idContratoStatus' => $_POST['idContratoStatus']
		);
		$contratoStatus = chamaAPI(null, '/services/contratostatus', json_encode($apiEntrada), 'DELETE');

	}

	header('Location: ../cadastros/contratoStatus.php');
	
}



?>