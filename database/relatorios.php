<?php
// helio 21032023 - compatibilidade chamada chamaApi
// helio 14022023 - criado

include_once('../conexao.php');

function buscaRelatorios($usercod=null)
{
	
	$relatorios = array();
	$apiEntrada = array(
		'usercod' => $usercod,
	);
	
	$relatorios = chamaAPI(null, 'ts/relatorios', json_encode($apiEntrada), 'GET');

	//echo json_encode ($relatorios);
	return $relatorios;

}


	//header('Location: ../cadastros/relatorios.php');	
	


?>
