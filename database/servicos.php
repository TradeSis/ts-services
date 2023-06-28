<?php
include_once('../conexao.php');
//Lucas 25052023 - modificado para Api
function buscaServicosCards()
{
    $servicos = array();
	//echo json_encode($servicos);
	//return;
	$apiEntrada = array(
		
	);
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */
	$servicos = chamaAPI(null, '/sistema/servicos_card', json_encode($apiEntrada), 'GET');
	//echo json_encode($servicos);
	return $servicos;
}

function buscaServicos($idServico=null)
{
    $servicos = array();
	//echo json_encode($servicos);
	//return;
	$apiEntrada = array(
		'idServico' => $idServico,
	);
	/* echo "-ENTRADA->".json_encode($apiEntrada)."\n";
	return; */
	$servicos = chamaAPI(null, '/sistema/servicos', json_encode($apiEntrada), 'GET');
	//echo json_encode($servicos);
	return $servicos;
}

function buscaSlugServicos($slugServicos)
{
    $servicos = array();
	$apiEntrada = array(
		'slugServicos' => $slugServicos,
	);
	$servicos = chamaAPI(null, '/sistema/servicos_slug', json_encode($apiEntrada), 'GET');
	//echo json_encode($servicos);
	return $servicos;
}





?>

