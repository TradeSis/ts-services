<?php
// helio 21032023 - chamaAPI, mudanca definição do primeiro parametro, ele será a URL, caso passado
// helio 03022023 alterado de if api para case(switch)
// helio 01022023 usando padrao defineConexaoApi
// helio 31012023 16:16 -  criado

function chamaAPI ($URL,$apiUrlParametros,$apiEntrada,$apiMethod) {

	if ($URL) {
		$apiIP=$URL;
	} else {
		$apiIP = defineConexaoApi();
	}
	
	$apiRetorno = array();
    
	// retirado switch, que testava o primeiro parametro
    $apiUrl = $apiIP.$apiUrlParametros;   
	
	$apiHeaders = array(
		"Content-Type: application/json"
	);

 	$apiCurl = curl_init($apiUrl);
	curl_setopt($apiCurl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($apiCurl, CURLOPT_CUSTOMREQUEST, $apiMethod);
	curl_setopt($apiCurl, CURLOPT_HTTPHEADER, $apiHeaders );
	if (isset($apiEntrada)) { 
		curl_setopt($apiCurl, CURLOPT_POSTFIELDS, $apiEntrada); 
	}
	curl_setopt($apiCurl, CURLOPT_ENCODING, '' );
	curl_setopt($apiCurl, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($apiCurl, CURLOPT_TIMEOUT, 0 );
	curl_setopt($apiCurl, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($apiCurl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
	
	$apiResponse = curl_exec($apiCurl);
	$apiInfo     = curl_getinfo($apiCurl);
    $erro = null;
    if (curl_errno($apiCurl)) {
       // $errno= curl_errno($apiCurl);
        $erro = curl_error($apiCurl);
    }

	curl_close($apiCurl);

	if ($apiInfo['http_code'] == 200) {
		$apiRetorno = json_decode($apiResponse, true);
	} else {
		$apiRetorno = 
			array("http_code" => $apiInfo['http_code'],
				  "erro"  => $erro);		
	}
	return $apiRetorno;

}

?>


