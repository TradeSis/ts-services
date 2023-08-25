<?php
// Lucas 22032023 - adicionado a operação filtrar, tituloContrato
// Lucas 21032023 - adicionado operação filtrar, idCliente e idContratoStatus
// Lucas 20032023 - buscaContratos ganhou parametro idCliente
// Lucas 20022023 - buscaContratos ganhou parametro idContratoStatus
// Lucas 14022023 - linha 96, modificado segundo parametro da chamda da api, adicionado "/tsservices/contrato/finalizar";
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

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . "/../conexao.php";

function buscaContratos($idContrato = null, $idContratoStatus = null, $idCliente = null)
{

	$contrato = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idContrato' => $idContrato,
		'idContratoStatus' => $idContratoStatus,
		'idCliente' => $idCliente,
		
	);
	$contrato = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'GET');

	return $contrato;
}
function buscaContratosAbertos()
{
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$contrato = array();
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'statusContrato' => '1' //Aberto
	);
	$contrato = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'GET');

	return $contrato;
}


function buscaCards($where)
{

	$cards = array();
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
	);
	$cards = chamaAPI(null, '/services/contrato/totais', json_encode($apiEntrada), 'GET');

	return $cards;
}



if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	if ($operacao == "inserir") {
		/* echo json_encode($_POST);
		return; */
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'tituloContrato' => $_POST['tituloContrato'],
			'descricao' => $_POST['descricao'],
			'idContratoStatus' => $_POST['idContratoStatus'],
			'dataPrevisao' => $_POST['dataPrevisao'],
			'dataEntrega' => $_POST['dataEntrega'],
			'idCliente' => $_POST['idCliente'],
			'horas' => $_POST['horas'],
			'valorHora' => $_POST['valorHora'],
			'valorContrato' => $_POST['valorContrato'],
			'statusContrato' => 1,
			'idContratoTipo' => $_POST['idContratoTipo'],
		);

		/* echo json_encode($apiEntrada);
		return; */
		$contratos = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'PUT');

		header('Location: ../contratos/index.php');
	}


	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContrato' => $_POST['idContrato'],
			'tituloContrato' => $_POST['tituloContrato'],
			'descricao' => $_POST['descricao'],
			'idContratoStatus' => $_POST['idContratoStatus'],
			'dataPrevisao' => $_POST['dataPrevisao'],
			'dataEntrega' => $_POST['dataEntrega'],
			'horas' => $_POST['horas'],
			'valorHora' => $_POST['valorHora'],
			'valorContrato' => $_POST['valorContrato'],

		);
		$contratos = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'POST');
		header('Location: ../contratos/index.php');
	}

	if ($operacao == "finalizar") {
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContrato' => $_POST['idContrato'],
			'dataFechamento' => $_POST['dataFechamento'],
			'statusContrato' => 0,
			'idContratoStatus' => 6

		);
		$contratos = chamaAPI(null, '/services/contrato/finalizar', json_encode($apiEntrada), 'POST');

		header('Location: ../contratos/index.php');
	}
	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContrato' => $_POST['idContrato'],

		);
		$contratos = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'DELETE');

		header('Location: ../contratos/index.php');
	}

	if ($operacao == "filtrar") {

		$idCliente = $_POST["idCliente"];
		$idContratoStatus = $_POST["idContratoStatus"];
		$tituloContrato = $_POST["tituloContrato"];
		$nomeContratoTipo = $_POST["nomeContratoTipo"];

		if ($idCliente == ""){
			$idCliente = null;
		}

		if ($idContratoStatus == ""){
			$idContratoStatus = null;
		} 

		if ($tituloContrato == ""){
			$tituloContrato = null;
		} 

		if ($nomeContratoTipo == ""){
			$nomeContratoTipo = null;
		} 

	
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idContrato' => null,
			'idCliente' => $idCliente,
			'idContratoStatus' => $idContratoStatus,
			'tituloContrato' => $tituloContrato,
			'nomeContratoTipo' => $nomeContratoTipo
		);
		
		$_SESSION['filtro_contrato'] = $apiEntrada;
		/* echo json_encode(($apiEntrada));
		return; */
		$contrato = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'GET');

		echo json_encode($contrato);
		return $contrato;

		header('Location: ../contratos/index.php');
	}
	
	
	
	

	//include "../contratos/contrato_ok.php";

}
