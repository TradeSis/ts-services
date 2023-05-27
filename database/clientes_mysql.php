<?php
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
	$conexao = conectaMysql();

	$sql = "SELECT * FROM cliente";
	if (isset($idCliente)) {
	  $sql = $sql . " where cliente.idCliente = " . $idCliente;
	}

    $rows = 0;
    $buscar = mysqli_query($conexao, $sql);
    while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
      array_push($clientes, $row);
      $rows = $rows + 1;
    }
    
    if (isset($idCliente) && $rows==1) {
      $clientes = $clientes[0];
    }

	return $clientes;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$nomeCliente = $_POST['nomeCliente'];
		$sql = "INSERT INTO cliente (nomeCliente) values ('$nomeCliente')";
	}

	if ($operacao=="alterar") {
		$idCliente = $_POST['idCliente'];
		$nomeCliente = $_POST['nomeCliente'];
		$sql = "UPDATE cliente SET nomeCliente='$nomeCliente' WHERE idCliente = $idCliente";
	}
	
	if ($operacao=="excluir") {
		$idCliente = $_POST['idCliente'];
		$sql = "DELETE FROM cliente WHERE idCliente = $idCliente";
	}

	$conexao = conectaMysql();
    $atualizar = mysqli_query($conexao,$sql);
    
	include "../cadastros/clientes_ok.php";
	
}

?>

