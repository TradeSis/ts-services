<?php


include_once('../conexao.php');

function buscaMenuProgramas($progrNome=null)
{

	$menuProgr = array();
	//echo json_encode($progrNome);
	//return;	
	$apiEntrada = array(
		'progrNome' => $progrNome,
	);
	
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */	
	$menuProgr = chamaAPI(null, '/api/services/menuprograma', json_encode($apiEntrada), 'GET');
	//echo json_encode($menuProgr);
	return $menuProgr;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$apiEntrada = array(
			'IDMenu' => $_POST['IDMenu'],
			'progrNome' => $_POST['progrNome'],
            'idAplicativo' => $_POST['idAplicativo'],
            'progrLink' => $_POST['progrLink'],
            'nivelMenu' => $_POST['nivelMenu'],		
		);

		$menuProgr = chamaAPI(null, '/api/services/menuprograma', json_encode($apiEntrada), 'PUT');
		
	}

    if ($operacao == "alterar") {
		$apiEntrada = array(
			'IDMenu' => $_POST['IDMenu'],
			'progrNome' => $_POST['progrNome'],
            'idAplicativo' => $_POST['idAplicativo'],
            'progrLink' => $_POST['progrLink'],
            'nivelMenu' => $_POST['nivelMenu'],
			
		);

		$menuProgr = chamaAPI(null, '/api/services/menuprograma', json_encode($apiEntrada), 'POST');
		
	}

	if ($operacao == "excluir") {
		$apiEntrada = array(
			'progrNome' => $_POST['progrNome']		
		);

		$menuProgr = chamaAPI(null, '/api/services/menuprograma', json_encode($apiEntrada), 'DELETE');
		
	}

	
	header('Location: ../sistema/menuprograma.php');
}
