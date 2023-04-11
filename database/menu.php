<?php
//Lucas 05042023 criado

include_once('../conexao.php');

function buscaMenu($IDMenu=null)
{
	
	$menu = array();
	//echo json_encode($menu);
	//return;
	$apiEntrada = array(
		'IDMenu' => $IDMenu,
	);
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */
	$menu = chamaAPI(null, '/api/services/menu', json_encode($apiEntrada), 'GET');
	//echo json_encode($menu);
	return $menu;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'nomeMenu' => $_POST['nomeMenu'],
            'idAplicativo' => $_POST['idAplicativo'],
            'nivelMenu' => $_POST['nivelMenu'],
		);
		$menu = chamaAPI(null, '/api/services/menu', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {
		$apiEntrada = array(
            
			'IDMenu' => $_POST['IDMenu'],
			'nomeMenu' => $_POST['nomeMenu'],
            'idAplicativo' => $_POST['idAplicativo'],
            'nivelMenu' => $_POST['nivelMenu'],
		);

		$menu = chamaAPI(null, '/api/services/menu', json_encode($apiEntrada), 'POST');
	}
	
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'IDMenu' => $_POST['IDMenu']
		);
		$menu = chamaAPI(null, '/api/services/menu', json_encode($apiEntrada), 'DELETE');
	}



	header('Location: ../sistema/menu.php');	
	
}

?>

