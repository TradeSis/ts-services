<?php
//lucas 28112023 id706 - Melhorias Demandas 2
// Lucas 25102023 id643 revisao geral
//Gabriel 05102023 ID 575 Demandas/Comentarios - Layout de chat
//lucas 26092023 ID 576 Demanda/BOTÕES de SITUACOES 
// Gabriel 22092023 id 544 Demandas - Botão Voltar
//lucas 22092023 ID 358 Demandas/Comentarios 
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

include_once __DIR__ . "/../conexao.php";

function buscaDemandas($idDemanda = null, $idTipoStatus = null, $idContrato = null)
{

	$demanda = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idDemanda' => $idDemanda,
		'idTipoStatus' => $idTipoStatus,
		'idContrato' => $idContrato,
		'idEmpresa' => $idEmpresa,
	);
	$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'GET');

	return $demanda;
}

function buscaComentarios($idDemanda = null, $idComentario = null)
{

	$comentario = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idDemanda' => $idDemanda,
		'idComentario' => $idComentario,
		'idEmpresa' => $idEmpresa,
	);
	$comentario = chamaAPI(null, '/services/comentario', json_encode($apiEntrada), 'GET');
	return $comentario;
}

function buscaCardsDemanda($idContratoTipo = null)
{
	$cards = array();


	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idContratoTipo' => $idContratoTipo
	);
	$cards = chamaAPI(null, '/services/demandas/totais', json_encode($apiEntrada), 'GET');
	return $cards;
}

function buscaDemandasAbertas($statusDemanda=1) //Aberto
{
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$demanda = array();
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'statusDemanda' => $statusDemanda
	);
	$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'GET');

	return $demanda;
}

function buscaTotalHorasCobrada($idContrato=null)
{
	$horas = array();


	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idContrato' => $idContrato
	);
	$horas = chamaAPI(null, '/services/demanda_horasCobrado', json_encode($apiEntrada), 'GET');
	return $horas;
}

function buscaTotalHorasReal($idContrato=null, $idDemanda=null)
{
	$horas = array();


	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idContrato' => $idContrato,
		'idDemanda' => $idDemanda
	);
	$horas = chamaAPI(null, '/services/demanda_horasReal', json_encode($apiEntrada), 'GET');
	return $horas;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCliente' => $_POST['idCliente'],
			'idSolicitante' => $_POST['idSolicitante'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'idServico' => $_POST['idServico'], //SERVICOS_PADRAO,
			'idTipoStatus' => $_POST['idTipoStatus'], //TIPOSTATUS_FILA,
			'idContrato' => $_POST['idContrato'],
			'idContratoTipo' => $_POST['idContratoTipo'],
			'horasPrevisao' => $_POST['horasPrevisao'],
			// lucas 21112023 - removido campo tamanho
			'idAtendente' => $_POST['idAtendente'],
			'dataPrevisaoEntrega' => $_POST['dataPrevisaoEntrega'],
			'dataPrevisaoInicio' => $_POST['dataPrevisaoInicio'],
			'tempoCobrado' => $_POST['tempoCobrado'],
		);
	
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'PUT');
		
		$tituloEmail = $_POST['tituloDemanda'];
		$corpoEmail = $_POST['descricao'];


		$arrayPara = array(

			array(
				'email' => 'tradesis@tradesis.com.br',
				'nome' => 'TradeSis'
			),
			array(
				'email' => $_SESSION['email'],
				'nome' => $_SESSION['usuario']
			),
		);

		$envio = emailEnviar(null,null,$arrayPara,$tituloEmail,$corpoEmail);
	
		// Lucas 25102023 id643 removido header
		/* header('Location: ../demandas/index.php?tipo='.$_POST['idContratoTipo']); */
	}

	//Gabriel 05102023 ID 575 inserir com mensagens do chat
	if ($operacao == "inserirChat") {

		if ($_POST['idContrato'] != '') {
			$idContrato = $_POST['idContrato'];
			$apiEntrada = array(
				'idEmpresa' => $_SESSION['idEmpresa'],
				'idContrato' => $idContrato,

			);
			$contrato = chamaAPI(null, '/services/contrato', json_encode($apiEntrada), 'GET');
			$idCliente = $contrato['idCliente'];
		} else {
			$idContrato = '';
			$idCliente = $_POST['idCliente'];
		}

		if ($_POST['idTipoOcorrencia'] == '') {
			$idTipoOcorrencia = OCORRENCIA_PADRAO;
		} else {
			$idTipoOcorrencia = $_POST['idTipoOcorrencia'];
		}

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCliente' => $idCliente,
			'idSolicitante' => $_POST['idSolicitante'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'idTipoOcorrencia' => $idTipoOcorrencia,
			'idServico' => SERVICOS_PADRAO,
			'idTipoStatus' => TIPOSTATUS_FILA,
			'idContrato' => $idContrato,
			'idContratoTipo' => $_POST['idContratoTipo'],
			'horasPrevisao' => $_POST['horasPrevisao'],
			'tamanho' => $_POST['tamanho'],
			'idAtendente' => $_POST['idAtendente']
		);

		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'PUT');

		if ($demanda['status'] === 200 && isset($demanda['idInserido'])) {
			$idDemanda = $demanda['idInserido'];

			$apiEntrada2 = array(
				'idEmpresa' => $_SESSION['idEmpresa'],
				'idDemanda' => $idDemanda,
				'INidUsuario' => $_POST['INidUsuario'],
				'OUTidUsuario' => $_POST['OUTidUsuario']
			);

			$chat = chamaAPI(null, '/services/demanda/chat', json_encode($apiEntrada2), 'PUT');
		}


		$tituloEmail = $_POST['tituloDemanda'];
		$corpoEmail = $_POST['descricao'];


		$arrayPara = array(

			array(
				'email' => 'tradesis@tradesis.com.br',
				'nome' => 'TradeSis'
			),
			array(
				'email' => $_SESSION['email'],
				'nome' => $_SESSION['usuario']
			),
		);

		$envio = emailEnviar(null, null, $arrayPara, $tituloEmail, $corpoEmail);
		
		header('Location: ../?tab=demandas');
	}

	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idDemanda' => $_POST['idDemanda'],
			'idContrato' => $_POST['idContrato'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			// lucas 06122023 id715  - removido descricao
			'prioridade' => $_POST['prioridade'],
			'idServico' => $_POST['idServico'],
			// lucas 21112023 id 688 - removido campo tamanho
			'idAtendente' => $_POST['idAtendente'],
			'horasPrevisao' => $_POST['horasPrevisao'],
			// lucas 21112023 id 688 - removido campo idContratoTipo
			'dataPrevisaoEntrega' => $_POST['dataPrevisaoEntrega'],
			'dataPrevisaoInicio' => $_POST['dataPrevisaoInicio'],
			'tempoCobrado' => $_POST['tempoCobrado'],
		);
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'POST');

		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}
	
	if ($operacao == "atualizar") {

		$acao = "";
        if (isset($_GET['acao'])) {
            $acao = $_GET['acao'];
        }

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idDemanda' => $_POST['idDemanda'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'comentario' => $_POST['comentario'],
			'idAtendente' => $_POST['idAtendente'],//utilizado quando ação for solicitar
			'acao' => $acao
		);
		
		$demanda = chamaAPI(null, '/services/demanda/atualizar', json_encode($apiEntrada), 'POST');
		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);

	}
	

	// lucas 22112023 id 688 - removido operação comentarioAtendente
	if ($operacao == "comentar") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'idDemanda' => $_POST['idDemanda'],
			'comentario' => $_POST['comentario']

		);

		$comentario = chamaAPI(null, '/services/comentario', json_encode($apiEntrada), 'PUT');
		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "descricao") {
		
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idDemanda' => $_POST['idDemanda'],
			'descricao' => $_POST['descricao'],
		);
		$demanda = chamaAPI(null, '/services/demanda_descricao', json_encode($apiEntrada), 'POST');

		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "filtrar") {

		$idCliente = $_POST['idCliente'];
		$idSolicitante = $_POST['idSolicitante'];
		$idTipoStatus = $_POST['idTipoStatus'];
		//Lucas 28112023 id706 - removido idTipoOcorrencia e adicionado idServico
		$idServico = $_POST['idServico'];
		$idAtendente = $_POST['idAtendente'];
		$statusDemanda = $_POST['statusDemanda'];
		$buscaDemanda = $_POST['buscaDemanda'];
		$idContratoTipo = $_POST["urlContratoTipo"];

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

		if ($idServico == "") {
			$idServico = null;
		}

		if ($statusDemanda == "") {
			$statusDemanda = null;
		}


		if ($buscaDemanda == "") {
			$buscaDemanda = null;
		}

		if ($idContratoTipo == ""){
			$idContratoTipo = null;
		}


		$idEmpresa = null;
		if (isset($_SESSION['idEmpresa'])) {
			$idEmpresa = $_SESSION['idEmpresa'];
		}

		$apiEntrada = array(
			'idEmpresa' => $idEmpresa,
			'idCliente' => $idCliente,
			'idSolicitante' => $idSolicitante,
			'idAtendente' => $idAtendente,
			'idTipoStatus' => $idTipoStatus,
			'idServico' => $idServico,
			'statusDemanda' => $statusDemanda,
			'buscaDemanda' => $buscaDemanda,
			'idContratoTipo' => $idContratoTipo,
		);

		$_SESSION['filtro_demanda'] = $apiEntrada;
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'GET');

		echo json_encode($demanda);
		return $demanda;
	}

	//Gabriel 22092023 id544 operação grava origem em session 
	if ($operacao == "origem") {
		$_SESSION['origem'] = $_POST['origem'];
	  }
}