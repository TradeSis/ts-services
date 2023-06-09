<?php
// Lucas 30032023 - modificado operação comentar para ser inserido anexos.
// gabriel 220323 11:19 - adicionado operação retornar demanda
// Lucas 21032023 adicionado a operação filtrar, Clientes,Usuarios,TipoStatus  e tipoOcorrencia.
// Lucas 20032023 adicionado operação filtrar
// gabriel 06032023 11:25 alteração de descricao demanda
// gabriel 02032023 12:13 alteração de titulo demanda
// Lucas 18022023 passado dois parametros na função buscaDemandas($idDemanda, $idTipoStatus)
// gabriel 06022023 adicionado inner join usuario linha 27, idatendente ao inserir demanda e prioridade no alterar
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// gabriel 31012023 13:47 - nomeclaturas, operação encerrar
// helio 26012023 16:16

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../conexao.php');


function buscaDemandas($idDemanda=null,$idTipoStatus=null,$idContrato=null)
{

	$demanda = array();
	//echo json_encode ($demanda);
	$apiEntrada = array(
		'idDemanda' => $idDemanda,
		'idTipoStatus' => $idTipoStatus,
		'idContrato' => $idContrato
	);
	//	echo json_encode(($apiEntrada));
	$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'GET');

	//echo json_encode ($demanda);
	return $demanda;
}



function buscaComentarios($idDemanda = null, $idComentario = null)
{

	$comentario = array();
	$apiEntrada = array(
		'idDemanda' => $idDemanda,
		'idComentario' => $idComentario,
	);
	$comentario = chamaAPI(null, '/services/comentario', json_encode($apiEntrada), 'GET');
	return $comentario;
}

function buscaCardsDemanda()
{
	$cards = array();
	$cards = chamaAPI(null, '/services/demandas/totais', null, 'GET');
	return $cards;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		
		$apiEntrada = array(
			'idCliente' => $_POST['idCliente'],
			//'idUsuario' => $_POST['idUsuario'],
			'idSolicitante' => $_POST['idSolicitante'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'idTipoStatus' => $_POST['idTipoStatus'],
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
		);
		/* echo json_encode($apiEntrada);
		return; */
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'PUT');

		$tituloEmail = $_POST['tituloDemanda'];
		$corpoEmail = $_POST['descricao'];
		

		$arrayPara    = array(
				
				array('email' => 'tradesis@tradesis.com.br',
				'nome'  => 'TradeSis'),
				array('email' => $_SESSION['email'],
				'nome'  => $_SESSION['usuario']),
		);

		//$envio = emailEnviar(null,null,$arrayPara,$tituloEmail,$corpoEmail);
		
	}
	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idDemanda' => $_POST['idDemanda'],
			'idContrato' => $_POST['idContrato'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'prioridade' => $_POST['prioridade'],
			'idTipoStatus' => $_POST['idTipoStatus'],
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
			'tamanho' => $_POST['tamanho'],
			'idAtendente' => $_POST['idAtendente'],
			'horasPrevisao' => $_POST['horasPrevisao'],
		);
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'POST');
	}
	if ($operacao == "encerrar") {
		$apiEntrada = array(
			'idDemanda' => $_POST['idDemanda'],
		);
		$demanda = chamaAPI(null, '/services/demanda/encerrar', json_encode($apiEntrada), 'POST');
	}
	if ($operacao == "retornar") {
		$apiEntrada = array(
			'idDemanda' => $_POST['idDemanda'],
		);
		$demanda = chamaAPI(null, '/services/demanda/retornar', json_encode($apiEntrada), 'POST');
	}

	if ($operacao == "comentar") {
 
		$anexo = $_FILES['nomeAnexo'];
	
		$pasta    = ROOT    . "/img/anexos/";
		$pastaURL = URLROOT . "/img/anexos/";

		$nomeAnexo = $anexo['name'];
		//$novoNomeDoAnexo = uniqid(); 
		$novoNomeDoAnexo = $_POST['idDemanda'] . "_" . $nomeAnexo;

		$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); 

		/* if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf" && $extensao != "cvs" && $extensao != "doc" && $extensao != "docx" && $extensao != "zip")
        die("Tipo de aquivo não aceito"); */

		$pathAnexo = $pasta    . $novoNomeDoAnexo . "." . $extensao;
		$pathURL   = $pastaURL . $novoNomeDoAnexo . "." . $extensao;

		move_uploaded_file($anexo["tmp_name"],$pathAnexo);


		$apiEntrada = array(
			'nomeAnexo' => $nomeAnexo,
			'pathAnexo' => $pathURL,
			'idUsuario' => $_POST['idUsuario'],
			'idDemanda' => $_POST['idDemanda'],
			'comentario' => $_POST['comentario']
		);
		

		$comentario = chamaAPI(null, '/services/comentario', json_encode($apiEntrada), 'PUT');
		/* echo json_encode(($comentario)); */
	}

	if ($operacao == "filtrar") {

		$idCliente = $_POST['idCliente'];
		$idSolicitante = $_POST['idSolicitante'];
		$idTipoStatus = $_POST['idTipoStatus'];
		$idTipoOcorrencia = $_POST['idTipoOcorrencia'];
		$idAtendente = $_POST['idAtendente'];
		$statusDemanda = $_POST['statusDemanda'];
		$tituloDemanda = $_POST['tituloDemanda'];
		$tamanho = $_POST['tamanho'];

		if ($idCliente == "") {
			$idCliente = null;
		}

		if ($idSolicitante == "") {
			$idSolicitante = null;
		}

		if ($idAtendente == "") {
			$idAtendente = null;
		}

		if ($idTipoStatus == "") {
			$idTipoStatus = null;
		}


		if ($idTipoOcorrencia == "") {
			$idTipoOcorrencia = null;
		}


		if ($statusDemanda == "") {
			$statusDemanda = null;
		}


		if ($tituloDemanda == ""){
			$tituloDemanda = null;
		}

		if ($tamanho == ""){
			$tamanho = null;
		}
		
		
	

		$apiEntrada = array(
			'idDemanda' => null,
			'idCliente' => $idCliente,
			'idSolicitante' => $idSolicitante,
			'idAtendente' => $idAtendente,
			'idTipoStatus' => $idTipoStatus,
			'idTipoOcorrencia' => $idTipoOcorrencia,
			'statusDemanda' => $statusDemanda,
			'tituloDemanda' => $tituloDemanda,
			'tamanho' => $tamanho
		);

		$_SESSION['filtro_demanda'] = $apiEntrada;
			/* echo json_encode(($apiEntrada));
		return; */
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'GET');

		echo json_encode($demanda);
		return $demanda;
	}

	/*
	include "../demandas/demanda_ok.php";
*/
	header('Location: ../demandas/index.php');
}
