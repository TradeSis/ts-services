<?php
// helio 03022023 alterado de if api para case(switch)
// helio 01022023 usando padrao defineConexaoApi
// helio 31012023 16:16 -  criado

function chamaAPI ($api,$apiUrlParametros,$apiEntrada,$apiMethod) {

	$apiIP = defineConexaoApi();
	
	$apiRetorno = array();
    
    switch ($api) {
        case "clientes":
            $apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
        break;

		case "contratostatus":
            $apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
        break;

		case "contrato":
            $apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
        break;

        case "seguros":
            $apiUrl = $apiIP.'/api/ts/' . $apiUrlParametros;
        break;
		case "tipostatus":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "tipoocorrencia":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "demanda":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "usuario":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "tarefas":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "horas":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "atendente":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
		  case "comentario":
			$apiUrl = $apiIP.'/api/services/' . $apiUrlParametros;
		  break;
  
		case "relatorios":
            $apiUrl = $apiIP.'/api/ts/' . $apiUrlParametros;
        break;

        default:
            $apiUrl = $apiIP.$apiUrlParametros;   
        break;
    }

	
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

	$apiResponse = curl_exec($apiCurl);
	$apiInfo     = curl_getinfo($apiCurl);

	curl_close($apiCurl);
          
	if ($apiInfo['http_code'] == 200) {
		$apiRetorno = json_decode($apiResponse, true);
	}
	return $apiRetorno;

}

?>


