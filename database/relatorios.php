<?php
// helio 14022023 - criado

include_once('../conexao.php');

function buscaRelatorios($usercod=null)
{
	
	$relatorios = array();
	$apiEntrada = array(
		'usercod' => $usercod,
	);
	$relatorios = chamaAPI('relatorios', 'relatorios', json_encode($apiEntrada), 'GET');

	//echo json_encode ($relatorios);
	return $relatorios;

}


	//header('Location: ../cadastros/relatorios.php');	
	


?>
