<?php
//Lucas 06042023 criado
include_once('conexao.php');

function buscaMontaMenu($idAplicativo=null)
{
	
	$menu = array();
	//echo json_encode($menu);
	//return;
	$apiEntrada = array(
		'idAplicativo' => $idAplicativo,
	);
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */
	$menu = chamaAPI(null, '/api/services/montaMenu', json_encode($apiEntrada), 'GET');
	//echo json_encode($menu);
	return $menu;
}


?>

