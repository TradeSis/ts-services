<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once __DIR__ . "/../conexao.php";


function save_task($idTipoStatus, $tituloDemanda, $idUsuario, $idContratoTipo, $idCliente)
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


function move_task($idDemanda, $idTipoStatus)
{
	$visaocli = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idDemanda' => $idDemanda,
		'idTipoStatus' => $idTipoStatus,
	);
	$visaocli = chamaAPI(null, '/services/visaocli', json_encode($apiEntrada), 'POST');

	return $visaocli;
}

function get_tasks($idTipoStatus, $idUsuario)
{
	$visaocli = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idTipoStatus' => $idTipoStatus,
		'idUsuario' => $idUsuario,
	);
	$visaocli = chamaAPI(null, '/services/visaocli', json_encode($apiEntrada), 'GET');

	return $visaocli;
}

function show_tile($kanbanDemanda)
{
	//$baseUrl = $_SERVER["PHP_SELF"] . "?shift&idDemanda=" . $kanbanDemanda["idDemanda"] . "&idTipoStatus=";
	$o = '<span class="card board mt-2 ts-click" id="kanbanCard" data-idDemanda="' .
		$kanbanDemanda["idDemanda"] . '"  >' . $kanbanDemanda["tituloDemanda"] . '
     
      </span>';
	return $o;
}

/* <hr>
<span>
  <a href="' . $baseUrl . '1">Aber</a> |
  <a href="' . $baseUrl . '5">Rea</a> |
  <a href="' . $baseUrl . '3">Exe</a> |
  <a href="' . $baseUrl . '7">Dev</a> |
  <a href="' . $baseUrl . '4">Ent</a> |
</span> */

function get_active_value($idTipoStatus, $content)
{
	$current_idTipoStatus = isset($_GET['idTipoStatus']) ? $_GET['idTipoStatus'] :  null;
	if ($current_idTipoStatus == $idTipoStatus) {
		return $content;
	}
	return "";
}

$idKanbanAtivo = "";
$kanbanAtivo = "";

if (isset($_GET['shift'])) {
	$idDemanda = isset($_GET['idDemanda']) ? $_GET['idDemanda'] : null;
	$idTipoStatus = isset($_GET['idTipoStatus']) ? $_GET['idTipoStatus'] : null;
	if ($idDemanda) {
		move_task($idDemanda, $idTipoStatus);
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	} else {
		// redirect take no action.
		header("Location: " . $_SERVER['PHP_SELF']);
	}
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['save-cartaoDemanda'])) {
		$idTipoStatus = isset($_POST['idTipoStatus']) ? $_POST['idTipoStatus'] : 1;
		$tituloDemanda = isset($_POST['tituloDemanda']) ? $_POST['tituloDemanda'] : null;
		$idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : null;
		$idContratoTipo = isset($_POST['idContratoTipo']) ? $_POST['idContratoTipo'] : null;
		$idCliente = isset($_POST['idCliente']) ? $_POST['idCliente'] : null;

		save_task($idTipoStatus, $tituloDemanda, $idUsuario, $idContratoTipo, $idCliente);
	}
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "demandacli") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idDemanda' => $_POST['idDemanda'],
			'prioridade' => $_POST['prioridade'],
		);

		$demanda = chamaAPI(null, '/services/visaocli', json_encode($apiEntrada), 'POST');

		header('Location: ../visaocli/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}
}
