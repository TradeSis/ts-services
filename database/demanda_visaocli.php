<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once __DIR__ . "/../conexao.php";


function salvarKanban($idTipoStatus, $tituloDemanda, $idUsuario, $idContratoTipo, $idCliente)
{
	$visaocli = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'tituloDemanda' => $tituloDemanda,
		'idTipoStatus' => $idTipoStatus,
		'idUsuario' => $idUsuario,
		'idContratoTipo' => $idContratoTipo,
		'idCliente' => $idCliente
	);
	$visaocli = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'PUT');

	return $visaocli;
}


function montaKanban($kanbanDemanda)
{
	$kanban = '<span class="card board mt-2 ts-click" id="kanbanCard" data-idDemanda="' .
		$kanbanDemanda["idDemanda"] . '"  >' . $kanbanDemanda["tituloDemanda"] . '
     
      </span>';
	return $kanban;
}

function statuskanbanAtivo($idTipoStatus, $content)
{
	$current_idTipoStatus = isset($_GET['idTipoStatus']) ? $_GET['idTipoStatus'] :  null;
	if ($current_idTipoStatus == $idTipoStatus) {
		return $content;
	}
	return "";
}

$kanbanAtivo = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['save-cartaoDemanda'])) {
		$idTipoStatus = isset($_POST['idTipoStatus']) ? $_POST['idTipoStatus'] : 1;
		$tituloDemanda = isset($_POST['tituloDemanda']) ? $_POST['tituloDemanda'] : null;
		$idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : null;
		$idContratoTipo = isset($_POST['idContratoTipo']) ? $_POST['idContratoTipo'] : null;
		$idCliente = isset($_POST['idCliente']) ? $_POST['idCliente'] : null;

		salvarKanban($idTipoStatus, $tituloDemanda, $idUsuario, $idContratoTipo, $idCliente);
	}
}

