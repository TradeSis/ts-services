<?php
//Lucas 06042023 criado

// NOVA VERSAO - Conexao esta ../
//include_once __DIR__."/../conexao.php";
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
	
	$menu = chamaAPI(null, '/services/montaMenu', json_encode($apiEntrada), 'GET');
	//echo json_encode($menu);
	return $menu;
}


?>

