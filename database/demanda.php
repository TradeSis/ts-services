<?php
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


include_once('../conexao.php');

function buscaDemandas($idDemanda = null, $idTipoStatus = null)
{

	$demanda = array();
	//echo json_encode ($demanda);
	$apiEntrada = array(
		'idDemanda' => $idDemanda,
		'idTipoStatus' => $idTipoStatus,
	);
	//	echo json_encode(($apiEntrada));
	$demanda = chamaAPI(null, '/api/services/demanda', json_encode($apiEntrada), 'GET');

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
	$comentario = chamaAPI(null, '/api/services/comentario', json_encode($apiEntrada), 'GET');
	return $comentario;
}
/*
function buscaCards($where)
{
	$conexao = conectaMysql();

	$sql = "SELECT COUNT(*) AS total FROM demanda" . $where;
	$buscar = mysqli_query($conexao, $sql);
	$demandas = array();
	while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
		array_push($demandas, $row);
	}

	return $demandas;
}
*/

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$apiEntrada = array(
			'idCliente' => $_POST['idCliente'],
			'idUsuario' => $_POST['idUsuario'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'idTipoStatus' => $_POST['idTipoStatus'],
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
		);
		$demanda = chamaAPI('demanda', 'demanda', json_encode($apiEntrada), 'PUT');
	}
	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idDemanda' => $_POST['idDemanda'],
			'tituloDemanda' => $_POST['tituloDemanda'],
			'descricao' => $_POST['descricao'],
			'prioridade' => $_POST['prioridade'],
			'idTipoStatus' => $_POST['idTipoStatus'],
			'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
			'tamanho' => $_POST['tamanho'],
			'idAtendente' => $_POST['idAtendente']
		);
		$demanda = chamaAPI(null, '/api/services/demanda', json_encode($apiEntrada), 'POST');
	}
	if ($operacao == "encerrar") {
		$apiEntrada = array(
			'idDemanda' => $_POST['idDemanda'],
		);
		$demanda = chamaAPI(null, '/api/services/demanda/encerrar', json_encode($apiEntrada), 'POST');
	}
	if ($operacao == "retornar") {
		$apiEntrada = array(
			'idDemanda' => $_POST['idDemanda'],
		);
		$demanda = chamaAPI(null, '/api/services/demanda/retornar', json_encode($apiEntrada), 'POST');
	}

	if ($operacao == "comentar") {
 
		$anexo = $_FILES['nomeAnexo'];
		

		/* if ($anexo['error']) // se gerar algum erro no upload
			die("Falha ao enviar arquivo"); */

		 /* if ($anexo['size'] > 3145728) //limitando tamnho do aquivo
			die("Aquivo muito grande!! MAX: 3MB"); */      
			
		//2MB:2097152-3MB:3145728
		//var_dump($_FILES['arquivo']);//inf do arquivo enviado 

		$pasta = "../img/anexos/";
		$nomeAnexo = $anexo['name'];
		$novoNomeDoAnexo = uniqid(); //gerar nome aleatorio para ser guardado na pasta 
		$extensao = strtolower(pathinfo($nomeAnexo,PATHINFO_EXTENSION)); //extensao do arquivo

		if($extensao != "" && $extensao != "jpg" && $extensao != "png" && $extensao != "xlsx" && $extensao != "pdf")
        die("Tipo de aquivo não aceito");

		$pathAnexo = $pasta . $novoNomeDoAnexo . "." . $extensao;
		move_uploaded_file($anexo["tmp_name"],$pathAnexo);


	/* 	if ($nomeAnexoInicial !== null) {
			preg_match("/\.(png|jpg|jpeg|xlsx|xls|pdf){1}$/i", $nomeAnexoInicial["name"], $ext);
			// Gera um nome Ãºnico para a imagem
			if ($ext == true) {

				$nomeAnexo = md5(uniqid(time())) . "." . $ext[1];

				$caminho_arquivo = "../img/anexos/" . $nomeAnexo;

				move_uploaded_file($nomeAnexoInicial["tmp_name"], $caminho_arquivo);
			}
		} */

		$apiEntrada = array(
			'nomeAnexo' => $nomeAnexo,
			'pathAnexo' => $pathAnexo,
			'idUsuario' => $_POST['idUsuario'],
			'idDemanda' => $_POST['idDemanda'],
			'comentario' => $_POST['comentario']
		);
		/* echo json_encode(($apiEntrada));
		return; */
		$comentario = chamaAPI(null, '/api/services/comentario', json_encode($apiEntrada), 'PUT');
		/* echo json_encode(($comentario)); */
	}

	if ($operacao == "filtrar") {

		$idCliente = $_POST['idCliente'];
		$idTipoStatus = $_POST['idTipoStatus'];
		$idTipoOcorrencia = $_POST['idTipoOcorrencia'];
		$idUsuario = $_POST['idUsuario'];

		if ($idCliente == "") {
			$idCliente = null;
		}

		if ($idUsuario == "") {
			$idUsuario = null;
		}

		if ($idTipoStatus == "") {
			$idTipoStatus = null;
		}


		if ($idTipoOcorrencia == "") {
			$idTipoOcorrencia = null;
		}



		$apiEntrada = array(
			'idDemanda' => null,
			'idCliente' => $idCliente,
			'idUsuario' => $idUsuario,
			'idTipoStatus' => $idTipoStatus,
			'idTipoOcorrencia' => $idTipoOcorrencia,

		);
			/* echo json_encode(($apiEntrada));
		return */;
		$demanda = chamaAPI(null, '/api/services/demanda', json_encode($apiEntrada), 'GET');

		echo json_encode($demanda);
		return $demanda;
	}

	/*
	include "../demandas/demanda_ok.php";
*/
	header('Location: ../demandas/index.php');
}
