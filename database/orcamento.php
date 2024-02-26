<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . "/../conexao.php";

function buscaOrcamentos($idOrcamento = null, $statusOrcamento = null, $idCliente = null)
{

	$orcamento = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idOrcamento' => $idOrcamento,
		'statusOrcamento' => $statusOrcamento,
		'idCliente' => $idCliente,
		
	);
	$orcamento = chamaAPI(null, '/services/orcamento', json_encode($apiEntrada), 'GET');

	return $orcamento;
}
function buscaOrcamentosAbertos($idCliente=null)
{
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$orcamento = array();
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'statusOrcamento' => '1', //Aberto
		'idCliente' => $idCliente,
	);
	$orcamento = chamaAPI(null, '/services/orcamento', json_encode($apiEntrada), 'GET');

	return $orcamento;
}




if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	if ($operacao == "inserir") {

		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'tituloOrcamento' => $_POST['tituloOrcamento'],
			'descricao' => $_POST['descricao'],
			'idCliente' => $_POST['idCliente'],
			'horas' => $_POST['horas'],
			'valorHora' => $_POST['valorHora'],
			'valorOrcamento' => $_POST['valorOrcamento']
		);
		
		$orcamentos = chamaAPI(null, '/services/orcamento', json_encode($apiEntrada), 'PUT');

		header('Location: ../orcamentos/index.php?tipo='.$_POST['idOrcamentoTipo']);
	}


	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idOrcamento' => $_POST['idOrcamento'],
			'tituloOrcamento' => $_POST['tituloOrcamento'],
			'descricao' => $_POST['descricao'],
			'horas' => $_POST['horas'],
			'valorHora' => $_POST['valorHora'],
			'valorOrcamento' => $_POST['valorOrcamento']
		);
		$orcamentos = chamaAPI(null, '/services/orcamento', json_encode($apiEntrada), 'POST');
		header('Location: ../orcamentos/index.php?tipo='.$_POST['idOrcamentoTipo']);
	}

	if ($operacao == "buscar") {
        $idCliente = $_POST["idCliente"];
        if ($idCliente == "") {
            $idCliente = null;
        }
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idCliente' => $idCliente,
			'statusOrcamento' => '1', //Aberto
        );
        $orcamento = chamaAPI(null, '/services/orcamento', json_encode($apiEntrada), 'GET');

        echo json_encode($orcamento);
        return $orcamento;
    }

	if ($operacao == "filtrar") {

		$idCliente = $_POST["idCliente"];
		$buscaOrcamento = $_POST["buscaOrcamento"];
		$statusOrcamento = $_POST['statusOrcamento'];

		if ($idCliente == ""){
			$idCliente = null;
		}

		if ($buscaOrcamento == ""){
			$buscaOrcamento = null;
		} 

		if ($statusOrcamento == ""){
			$statusOrcamento = null;
		}

	
		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idCliente' => $idCliente,
			'buscaOrcamento' => $buscaOrcamento,
			'statusOrcamento' => $statusOrcamento
		);
		
		$_SESSION['filtro_orcamento'] = $apiEntrada;
		
		$orcamento = chamaAPI(null, '/services/orcamento', json_encode($apiEntrada), 'GET');

		echo json_encode($orcamento);
		return $orcamento;

		header('Location: ../orcamentos/index.php');
	}
	
	

}
