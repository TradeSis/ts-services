<?php
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

function buscaCardsDemanda()
{
	$cards = array();


	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
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

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			//'idCliente' => $_POST['idCliente'],
			'idSolicitante' => $_POST['idSolicitante'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
			'idServico' => $_POST['idServico'], //SERVICOS_PADRAO,
			'idTipoStatus' => $_POST['idTipoStatus'], //TIPOSTATUS_FILA,
			'idContrato' => $_POST['idContrato'],
			'idContratoTipo' => $_POST['idContratoTipo'],
			'horasPrevisao' => $_POST['horasPrevisao'],
			// lucas 21112023 - removido campo tamanho
			'idAtendente' => $_POST['idAtendente'],
			
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
			'descricao' => $_POST['descricao'],
			'prioridade' => $_POST['prioridade'],
			'idServico' => $_POST['idServico'],
			// lucas 21112023 id 688 - removido campo tamanho
			'idAtendente' => $_POST['idAtendente'],
			'horasPrevisao' => $_POST['horasPrevisao'],
			// lucas 21112023 id 688 - removido campo idContratoTipo
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia']
		);
		$demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'POST');

		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}
	
	if ($operacao == "realizado") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idDemanda' => $_POST['idDemanda'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'comentario' => $_POST['comentario'],
			'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
			'idTarefa' => $_POST['idTarefa'],
		);
		
		$demanda = chamaAPI(null, '/services/demanda/realizado', json_encode($apiEntrada), 'POST');
		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);

	}
	
	if ($operacao == "validar") {
		/*$anexo = $_FILES['nomeAnexo'];
		
		$pasta    = ROOT    . "/img/anexos/";
		$pastaURL = URLROOT . "/img/anexos/";
		
		$nomeAnexo = $anexo['name'];
		//$novoNomeDoAnexo = uniqid(); 
		$novoNomeDoAnexo = $_POST['idDemanda'] . "_" . $nomeAnexo;
		
		$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); 
		
		if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf" && $extensao != "cvs" && $extensao != "doc" && $extensao != "docx" && $extensao != "zip")
		die("Tipo de aquivo não aceito"); 
		
		$pathAnexo = $pasta    . $novoNomeDoAnexo . "." . $extensao;
		$pathURL   = $pastaURL . $novoNomeDoAnexo . "." . $extensao;
		
		move_uploaded_file($anexo["tmp_name"],$pathAnexo); */
		
		$apiEntrada = array(
			//'nomeAnexo' => $nomeAnexo,
			//'pathAnexo' => $pathURL,
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'idDemanda' => $_POST['idDemanda'],
			//'comentario' => $_POST['comentario'],
			'idTipoStatus' => TIPOSTATUS_VALIDADO

		);

		if($_POST['comentario'] != ""){
			$apiEntrada2 = array(
				//'nomeAnexo' => $nomeAnexo,
				//'pathAnexo' => $pathURL,
				'idEmpresa' => $_SESSION['idEmpresa'],
				'idUsuario' => $_POST['idUsuario'],
				'idCliente' => $_POST['idCliente'],
				'idDemanda' => $_POST['idDemanda'],
				'comentario' => $_POST['comentario'],
				'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
				'idTipoStatus' => TIPOSTATUS_RESPONDIDO
	
			);
			$comentario2 = chamaAPI(null, '/services/comentario/cliente', json_encode($apiEntrada2), 'PUT');
		}
		
		$comentario = chamaAPI(null, '/services/demanda/validar', json_encode($apiEntrada), 'PUT');
		
		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "retornar") {
		/*$anexo = $_FILES['nomeAnexo'];
		
		$pasta    = ROOT    . "/img/anexos/";
		$pastaURL = URLROOT . "/img/anexos/";
		
		$nomeAnexo = $anexo['name'];
		//$novoNomeDoAnexo = uniqid(); 
		$novoNomeDoAnexo = $_POST['idDemanda'] . "_" . $nomeAnexo;
		
		$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); 
		
		if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf" && $extensao != "cvs" && $extensao != "doc" && $extensao != "docx" && $extensao != "zip")
		die("Tipo de aquivo não aceito"); 
		
		$pathAnexo = $pasta    . $novoNomeDoAnexo . "." . $extensao;
		$pathURL   = $pastaURL . $novoNomeDoAnexo . "." . $extensao;
		
		move_uploaded_file($anexo["tmp_name"],$pathAnexo); */

		
		$apiEntrada = array(
			//'nomeAnexo' => $nomeAnexo,
			//'pathAnexo' => $pathURL,
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'idDemanda' => $_POST['idDemanda'],
			//'comentario' => $_POST['comentario'],
			'idTipoStatus' => TIPOSTATUS_RETORNO

		);

		if($_POST['comentario'] != ""){
			$apiEntrada2 = array(
				//'nomeAnexo' => $nomeAnexo,
				//'pathAnexo' => $pathURL,
				'idEmpresa' => $_SESSION['idEmpresa'],
				'idUsuario' => $_POST['idUsuario'],
				'idCliente' => $_POST['idCliente'],
				'idDemanda' => $_POST['idDemanda'],
				'comentario' => $_POST['comentario'],
				'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
				'idTipoStatus' => TIPOSTATUS_RESPONDIDO
	
			);
			$comentario2 = chamaAPI(null, '/services/comentario/cliente', json_encode($apiEntrada2), 'PUT');
		}

		$comentario = chamaAPI(null, '/services/demanda/retornar', json_encode($apiEntrada), 'PUT');
		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "comentar") {

		/*$anexo = $_FILES['nomeAnexo'];
							
								$pasta    = ROOT    . "/img/anexos/";
								$pastaURL = URLROOT . "/img/anexos/";

								$nomeAnexo = $anexo['name'];
								//$novoNomeDoAnexo = uniqid(); 
								$novoNomeDoAnexo = $_POST['idDemanda'] . "_" . $nomeAnexo;

								$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); 

								 if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf" && $extensao != "cvs" && $extensao != "doc" && $extensao != "docx" && $extensao != "zip")
								die("Tipo de aquivo não aceito"); 

								$pathAnexo = $pasta    . $novoNomeDoAnexo . "." . $extensao;
								$pathURL   = $pastaURL . $novoNomeDoAnexo . "." . $extensao;

								move_uploaded_file($anexo["tmp_name"],$pathAnexo); */


		$apiEntrada = array(
			//'nomeAnexo' => $nomeAnexo,
			//'pathAnexo' => $pathURL,
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'idDemanda' => $_POST['idDemanda'],
			'comentario' => $_POST['comentario'],
			'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
			'idTipoStatus' => TIPOSTATUS_RESPONDIDO

		);

		$comentario = chamaAPI(null, '/services/comentario/cliente', json_encode($apiEntrada), 'PUT');

		header('Location: ../demandas/visualizar.php?id=comentarios&&idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "comentarAtendente") {

		/* echo json_encode($_FILES);
		//echo json_encode($_POST);
		return; */
		/*$anexo = $_FILES['nomeAnexo'];
							
								$pasta    = ROOT    . "/img/anexos/";
								$pastaURL = URLROOT . "/img/anexos/";

								$nomeAnexo = $anexo['name'];
								//$novoNomeDoAnexo = uniqid(); 
								$novoNomeDoAnexo = $_POST['idDemanda'] . "_" . $nomeAnexo;

								$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); 

								 if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf" && $extensao != "cvs" && $extensao != "doc" && $extensao != "docx" && $extensao != "zip")
								die("Tipo de aquivo não aceito"); 

								$pathAnexo = $pasta    . $novoNomeDoAnexo . "." . $extensao;
								$pathURL   = $pastaURL . $novoNomeDoAnexo . "." . $extensao;

								move_uploaded_file($anexo["tmp_name"],$pathAnexo); */

								$anexo = $_FILES['nomeAnexo'];

								if($anexo !== null) {
									preg_match("/\.(png|jpg|jpeg|txt|xlsx|pdf|csv|doc|docx|zip){1}$/i", $anexo["name"],$ext);
								
									if($ext == true) {
										$pasta = ROOT . "/img/";
										
										$novoNomeAnexo = $_POST['idDemanda']. "_" .$anexo["name"];
										$pathAnexo = 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNomeAnexo;
										move_uploaded_file($anexo['tmp_name'], $pasta.$novoNomeAnexo);
								
										
									}else{
										$novoNomeAnexo = " ";
									}
							
								}

		$apiEntrada = array(
			'nomeAnexo' => $novoNomeAnexo,
			'pathAnexo' => $pathAnexo,
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'idDemanda' => $_POST['idDemanda'],
			'comentario' => $_POST['comentario'],
			'idTipoStatus' => null

		);

		$comentario = chamaAPI(null, '/services/comentario/atendente', json_encode($apiEntrada), 'PUT');

		header('Location: ../demandas/visualizar.php?id=comentarios&&idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "solicitar") {

		/*$anexo = $_FILES['nomeAnexo'];
							
								$pasta    = ROOT    . "/img/anexos/";
								$pastaURL = URLROOT . "/img/anexos/";

								$nomeAnexo = $anexo['name'];
								//$novoNomeDoAnexo = uniqid(); 
								$novoNomeDoAnexo = $_POST['idDemanda'] . "_" . $nomeAnexo;

								$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); 

								if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf" && $extensao != "cvs" && $extensao != "doc" && $extensao != "docx" && $extensao != "zip")
								die("Tipo de aquivo não aceito"); 

								$pathAnexo = $pasta    . $novoNomeDoAnexo . "." . $extensao;
								$pathURL   = $pastaURL . $novoNomeDoAnexo . "." . $extensao;

								move_uploaded_file($anexo["tmp_name"],$pathAnexo); */

		if($_POST['comentario'] != ""){
			$comentario = $_POST['comentario'];
		} else{
			$comentario = null;
		}
		$apiEntrada = array(
			//'nomeAnexo' => $nomeAnexo,
			//'pathAnexo' => $pathURL,
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'idCliente' => $_POST['idCliente'],
			'idDemanda' => $_POST['idDemanda'],
			'comentario' => $comentario,
			'idTipoStatus' => TIPOSTATUS_AGUARDANDOSOLICITANTE,
			//lucas 22092023 ID 358 Adicionado idAtendente
			'idAtendente' => $_POST['idAtendente'],
		);

		$comentario = chamaAPI(null, '/services/comentario/atendente', json_encode($apiEntrada), 'PUT');

		header('Location: ../demandas/visualizar.php?idDemanda=' . $apiEntrada['idDemanda']);
	}

	if ($operacao == "filtrar") {

		$idCliente = $_POST['idCliente'];
		$idSolicitante = $_POST['idSolicitante'];
		$idTipoStatus = $_POST['idTipoStatus'];
		$idTipoOcorrencia = $_POST['idTipoOcorrencia'];
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


		if ($idTipoOcorrencia == "") {
			$idTipoOcorrencia = null;
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
			'idTipoOcorrencia' => $idTipoOcorrencia,
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