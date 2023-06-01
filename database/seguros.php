<?php
// helio 21032023 - compatibilidade chamada chamaApi
// Lucas 15022023 - criado

include_once('../conexao.php');

function buscaSeguros($codigoCliente,$codigoFilial,$recID)/* ($recID=null) */
{
	
	$seguros = array();
	$apiEntrada = array(
		'recID' => $recID,
        'codigoCliente' => $codigoCliente,
		'codigoFilial' => $codigoFilial
	);
	$seguros = chamaAPI(null, 'ts/seguros', json_encode($apiEntrada), 'GET');

	//echo json_encode ($seguros);

    if (isset($seguros["seguros"])) {
        $seguros = $seguros["seguros"];
    }

	return $seguros;

}


	//header('Location: ../cadastros/seguros.php');	
	


?>