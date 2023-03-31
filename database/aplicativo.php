<?php


include_once('../conexao.php');

function buscaAplicativos($nomeAplicativo=null)
{

	$aplicativo = array();
	//echo json_encode($aplicativo);
	//return;	
	$apiEntrada = array(
		'nomeAplicativo' => $nomeAplicativo,
	);
	
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return;	 */
	$aplicativo = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'GET');
	//echo json_encode($aplicativo);
	return $aplicativo;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$apiEntrada = array(
			'aplicativo' => $_POST['aplicativo'],
			'nomeAplicativo' => $_POST['nomeAplicativo'],
			'imgAplicativo' => $_POST['imgAplicativo'],
			
		);
		/*  echo json_encode($_POST);
		echo "\n";
		echo json_encode($apiEntrada);
		return;  */
		$aplicativo = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'PUT');
		
	}

    if ($operacao == "alterar") {
		$apiEntrada = array(
			'aplicativo' => $_POST['aplicativo'],
			'nomeAplicativo' => $_POST['nomeAplicativo'],
			'imgAplicativo' => $_POST['imgAplicativo'],
			
		);
		$aplicativo = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'POST');
		
	}

	
	header('Location: ../sistema/aplicativo.php');
}
