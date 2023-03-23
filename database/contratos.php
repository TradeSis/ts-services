<?php
// Lucas 21032023 - adicionado operação filtrar, idCliente e idContratoStatus
// Lucas 20032023 - buscaContratos ganhou parametro idCliente
// Lucas 20022023 - buscaContratos ganhou parametro idContratoStatus
// Lucas 14022023 - linha 96, modificado segundo parametro da chamda da api, adicionado "/api/tsservices/contrato/finalizar";
// Lucas 09022023 - corrigido erro de sintaxa - "hora" para "horas"
// Helio 01022023 - compatibilidade com conectaMysql
// Helio 01022023 alterado para include_once
// Lucas 01022023 - Adicionado operação inserir;
// Lucas 01022023 - Adicionado no alterar os campos dataPrevisao e dataEntrega e retirado o dataFechamento;
// Lucas 01022023 - Adicionado no inserir os campos dataPrevisao e dataEntrega;
// Lucas 01022023 - Removido "dataFechamento" do inserir, linha 64 e 74;
// Lucas 01022023 18:22
// Lucas 31012023 - Alterado "id" para "idContrato", linhas 79 e 93;
// Lucas 31012023 20:34

include_once '../conexao.php';

function buscaContratos($idContrato = null, $idContratoStatus = null, $idCliente = null)
{

	$contrato = array();
	//echo json_encode ($contrato);
	$apiEntrada = array(
		'idContrato' => $idContrato,
		'idContratoStatus' => $idContratoStatus,
		'idCliente' => $idCliente
	);
	//echo json_encode(($apiEntrada));
	$contrato = chamaAPI(null, '/api/services/contrato', json_encode($apiEntrada), 'GET');

	//echo json_encode ($contrato);
	return $contrato;
}


function buscaCards($where)
{

	$cards = array();
	$apiEntrada = array();
	//echo json_encode(($apiEntrada));
	$cards = chamaAPI(null, '/api/services/contrato/totais', json_encode($apiEntrada), 'GET');

	//echo "database=".json_encode ($cards);
	return $cards;
}



if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'tituloContrato' => $_POST['tituloContrato'],
			'descricao' => $_POST['descricao'],
			'idContratoStatus' => $_POST['idContratoStatus'],
			'dataPrevisao' => $_POST['dataPrevisao'],
			'dataEntrega' => $_POST['dataEntrega'],
			'idCliente' => $_POST['idCliente'],
			'horas' => $_POST['horas'],
			'valorHora' => $_POST['valorHora'],
			'valorContrato' => $_POST['valorContrato'],

		);
		$contratos = chamaAPI(null, '/api/services/contrato', json_encode($apiEntrada), 'PUT');
	}


	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idContrato' => $_POST['idContrato'],
			'tituloContrato' => $_POST['tituloContrato'],
			'descricao' => $_POST['descricao'],
			'idContratoStatus' => $_POST['idContratoStatus'],
			'dataPrevisao' => $_POST['dataPrevisao'],
			'dataEntrega' => $_POST['dataEntrega'],
			'idCliente' => $_POST['idCliente'],
			'horas' => $_POST['horas'],
			'valorHora' => $_POST['valorHora'],
			'valorContrato' => $_POST['valorContrato'],

		);
		$contratos = chamaAPI(null, '/api/services/contrato', json_encode($apiEntrada), 'POST');
	}

	if ($operacao == "finalizar") {
		$apiEntrada = array(
			'idContrato' => $_POST['idContrato'],
			'dataFechamento' => $_POST['dataFechamento'],


		);
		$contratos = chamaAPI(null, '/api/services/contrato/finalizar', json_encode($apiEntrada), 'POST');
	}
	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idContrato' => $_POST['idContrato'],

		);
		$contratos = chamaAPI(null, '/api/services/contrato', json_encode($apiEntrada), 'DELETE');
	}

	if ($operacao == "filtrar") {

		$idCliente = $_POST["idCliente"];
		$idContratoStatus = $_POST["idContratoStatus"];
		$tituloContrato = $_POST["tituloContrato"];

		if ($idCliente == ""){
			$idCliente = null;
		}

		if ($idContratoStatus == ""){
			$idContratoStatus = null;
		} 

		if ($tituloContrato == ""){
			$tituloContrato = null;
		} 


		$apiEntrada = array(
			'idContrato' => null,
			'idCliente' => $idCliente,
			'idContratoStatus' => $idContratoStatus,
			'tituloContrato' => $tituloContrato
		);
		/* echo json_encode(($apiEntrada));
		return; */
		$contrato = chamaAPI(null, '/api/services/contrato', json_encode($apiEntrada), 'GET');

		echo json_encode($contrato);
		return $contrato;
	}
	


	header('Location: ../contratos/index.php');

	//include "../contratos/contrato_ok.php";

}
