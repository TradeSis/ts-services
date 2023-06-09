<?php
//Lucas 06042023 criado
include_once('conexao.php');
function buscaMontaMenu($nomeAplicativo,$idUsuario)
{
	
	$menu = array();
	//echo json_encode($menu);
	//return;
	$apiEntrada = array(
		'nomeAplicativo' => $nomeAplicativo, 
		'idUsuario' => $idUsuario,
	);
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */
	$menu = chamaAPI(null, '/services/montaMenu', json_encode($apiEntrada), 'GET');
	//echo json_encode($menu);
	return $menu;
}


?>

