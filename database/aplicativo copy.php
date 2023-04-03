<?php


include_once('../conexao.php');

function buscaAplicativos($aplicativo=null)
{

	$app = array();
	//echo json_encode($aplicativo);
	//return;	
	$apiEntrada = array(
		'aplicativo' => $aplicativo,
	);
	
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */	
	$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'GET');
	//echo json_encode($app);
	return $app;
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
		$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'PUT');
		
	}

    if ($operacao == "alterar") {
		$apiEntrada = array(
			'aplicativo' => $_POST['aplicativo'],
			'nomeAplicativo' => $_POST['nomeAplicativo'],
			'imgAplicativo' => $_POST['imgAplicativo'],
			
		);

		$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'POST');
		
	}

	if ($operacao == "excluir") {
		$apiEntrada = array(
			'aplicativo' => $_POST['aplicativo']		
		);

		$app = chamaAPI(null, '/api/services/aplicativo', json_encode($apiEntrada), 'DELETE');
		
	}

	
	header('Location: ../sistema/aplicativo.php');
}
