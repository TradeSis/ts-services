<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "demanda_inserir";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "services_" . date("dmY") . ".log", "a");
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
    $idCliente = $jsonEntrada['idCliente'];
    $tituloDemanda = $jsonEntrada['tituloDemanda'];
    $descricao = $jsonEntrada['descricao'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];
    $idSolicitante = isset($jsonEntrada['idSolicitante']) && $jsonEntrada['idSolicitante'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idSolicitante']) : "NULL";
    $idServico = isset($jsonEntrada['idServico']) && $jsonEntrada['idServico'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idServico']) : "NULL";
    $idContrato = isset($jsonEntrada['idContrato']) && $jsonEntrada['idContrato'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idContrato']) : "NULL";
    $idContratoTipo = isset($jsonEntrada['idContratoTipo']) && $jsonEntrada['idContratoTipo'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['idContratoTipo']) . "'" : "NULL";
    $horasPrevisao = isset($jsonEntrada['horasPrevisao']) && $jsonEntrada['horasPrevisao'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horasPrevisao']) . "'" : "NULL";
    $tamanho = isset($jsonEntrada['tamanho']) && $jsonEntrada['tamanho'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['tamanho']) . "'" : "NULL";
    $idAtendente = isset($jsonEntrada['idAtendente']) && $jsonEntrada['idAtendente'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idAtendente']) : "NULL";

    //busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];

    $sql = "INSERT INTO demanda(prioridade, tituloDemanda, descricao, dataAbertura, idTipoStatus, idTipoOcorrencia, posicao, statusDemanda, idCliente, idSolicitante, idServico, idContrato, idContratoTipo, horasPrevisao, tamanho, idAtendente) VALUES (99, '$tituloDemanda','$descricao', CURRENT_TIMESTAMP(), $idTipoStatus, $idTipoOcorrencia, $posicao, $statusDemanda, $idCliente, $idSolicitante, $idServico, $idContrato, $idContratoTipo, $horasPrevisao, $tamanho, $idAtendente)";

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

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
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

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
