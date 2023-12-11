<?php
//Gabriel 05102023 ID 575 Demandas/Comentarios - Layout de chat
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "demanda_inserir";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "services_inserir" . date("dmY") . ".log", "a");
        }
    }

}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG


$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);
$posicao = null;
$statusDemanda = null;

if (isset($jsonEntrada['tituloDemanda'])) {
    $tituloDemanda = "'" . $jsonEntrada['tituloDemanda'] . "'";
    $descricao = "'" . $jsonEntrada['descricao'] . "'";
    $horasPrevisao  = isset($jsonEntrada['horasPrevisao'])  && $jsonEntrada['horasPrevisao'] !== "" && $jsonEntrada['horasPrevisao'] !== "null" ? "'". $jsonEntrada['horasPrevisao']."'"  : "0";
    $idSolicitante = isset($jsonEntrada['idSolicitante'])  && $jsonEntrada['idSolicitante'] !== "" ?  $jsonEntrada['idSolicitante']    : "null";
    $idAtendente = isset($jsonEntrada['idAtendente'])  && $jsonEntrada['idAtendente'] !== "" ?  $jsonEntrada['idAtendente']    : "null";
    $idCliente = isset($jsonEntrada['idCliente'])  && $jsonEntrada['idCliente'] !== "" ?  $jsonEntrada['idCliente']    : "null";

    $idContratoTipo   = isset($jsonEntrada['idContratoTipo'])  && $jsonEntrada['idContratoTipo'] !== "" ?  "'" . $jsonEntrada['idContratoTipo'] . "'"  : "null";
        //Verifica o Tipo de Contrato
        $sql_consulta = "SELECT * FROM contratotipos WHERE idContratoTipo = $idContratoTipo";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);

        $idServicoPadrao = isset($row_consulta['idServicoPadrao'])  && $row_consulta['idServicoPadrao'] !== "" ?  $row_consulta['idServicoPadrao']    : "null";
        $idTipoStatus_fila = isset($row_consulta['idTipoStatus_fila'])  && $row_consulta['idTipoStatus_fila'] !== "" ?  $row_consulta['idTipoStatus_fila']    : "null";
        $idTipoOcorrenciaPadrao = isset($row_consulta['idTipoOcorrenciaPadrao'])  && $row_consulta['idTipoOcorrenciaPadrao'] !== "" ?  $row_consulta['idTipoOcorrenciaPadrao']    : "null";

        $idTipoOcorrencia  = isset($jsonEntrada['idTipoOcorrencia'])  && $jsonEntrada['idTipoOcorrencia'] !== "" ?  $jsonEntrada['idTipoOcorrencia']    : "null";
        if($idTipoOcorrencia === "null"){
            $idTipoOcorrencia = $idTipoOcorrenciaPadrao;
        }

        $idServico  = isset($jsonEntrada['idServico'])  && $jsonEntrada['idServico'] !== "" ?  $jsonEntrada['idServico']    : "null";
        if($idServico === "null"){
            $idServico = $idServicoPadrao;
        }
 
        $idTipoStatus = $idTipoStatus_fila;


    $idContrato = isset($jsonEntrada['idContrato'])  && $jsonEntrada['idContrato'] !== "" ?  $jsonEntrada['idContrato']    : "null";

    if($idContrato !== "null"){
        //Pega o campo idCliente de contrato
        $sql_consulta = "SELECT * FROM contrato WHERE idContrato = $idContrato";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $idCliente = isset($row_consulta['idCliente'])  && $row_consulta['idCliente'] !== "" ?  $row_consulta['idCliente']    : "null";
    }


    //busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];

    $sql = "INSERT INTO demanda(prioridade, tituloDemanda, descricao, dataAbertura, idTipoStatus, idTipoOcorrencia, posicao, statusDemanda, idCliente, idSolicitante, idServico, idContrato, idContratoTipo, horasPrevisao, idAtendente)
     VALUES (99, $tituloDemanda, $descricao, CURRENT_TIMESTAMP(), $idTipoStatus, $idTipoOcorrencia, $posicao, $statusDemanda, $idCliente, $idSolicitante, $idServico, $idContrato, $idContratoTipo, $horasPrevisao, $idAtendente)";
    
    //Envio de Email
    $tituloEmail = $jsonEntrada['tituloDemanda'];
    $corpoEmail = $jsonEntrada['descricao'];

    $arrayPara = array(

        array(
            'email' => 'tradesis@tradesis.com.br',
            'nome' => 'TradeSis'
        ),
        array(
            'email' => $_SESSION['email'],
            'nome' => $_SESSION['usuario']
        ),
    );

    $envio = emailEnviar(null,null,$arrayPara,$tituloEmail,$corpoEmail);

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {
        
        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));
        //Gabriel 05102023 ID 575 adicionado idDemanda adicionada
        $idInserido = mysqli_insert_id($conexao);
    
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok",
            "idInserido" => $idInserido  
        );  
    } catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }

    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH


} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );

}
//echo "-SAIDA->".json_encode($jsonSaida)."\n";
//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
