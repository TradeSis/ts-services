<?php
// helio 21032023 - compatibilidade chamada chamaApi
// helio 01022023 alterado para include_once
// helio 31012023 - eliminado funcao buscaCliente, ficou apenas buscaClientes,
//					o parametro mudou para o idCliente, e não mais string(where)
//					colocado chamada chamaAPI					
// helio 26012023 - function buscasClientes - Retirado mysql e Colocado CURL (API)
// helio 26012023 16:16

include_once('../conexao.php');

function buscaClientes($idCliente=null)
{
	
	$clientes = array();
	//echo json_encode($clientes);
	//return;
	$apiEntrada = array(
		'idCliente' => $idCliente,
	);
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */
	$clientes = chamaAPI(null, '/services/clientes', json_encode($apiEntrada), 'GET');
	//echo json_encode($clientes);
	return $clientes;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'nomeCliente' => $_POST['nomeCliente']
		);
		$clientes = chamaAPI(null, '/services/clientes', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {
		$apiEntrada = array(
			'idCliente' => $_POST['idCliente'],
			'nomeCliente' => $_POST['nomeCliente']
		);
		$clientes = chamaAPI(null, 'servives/clientes', json_encode($apiEntrada), 'POST');
	}
	
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idCliente' => $_POST['idCliente']
		);
		$clientes = chamaAPI(null, '/services/clientes', json_encode($apiEntrada), 'DELETE');
	}


//	include "../cadastros/clientes_ok.php";

	header('Location: ../cadastros/clientes.php');	
	
}

?>

