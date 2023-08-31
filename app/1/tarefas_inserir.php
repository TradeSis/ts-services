<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "tarefas_inserir";
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

$statusTarefa = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_RESPONDIDO,
);

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);

if (isset($jsonEntrada['idDemanda'])) {
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $idCliente = $jsonEntrada['idCliente'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $idAtendente = $jsonEntrada['idAtendente'];
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];
    $tipoStatusDemanda = $jsonEntrada['tipoStatusDemanda'];
    $horaCobrado = isset($jsonEntrada['horaCobrado']) && $jsonEntrada['horaCobrado'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaCobrado']) . "'" : "NULL";
    $Previsto = isset($jsonEntrada['Previsto']) && $jsonEntrada['Previsto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['Previsto']) . "'" : "NULL";
    $horaInicioPrevisto = isset($jsonEntrada['horaInicioPrevisto']) && $jsonEntrada['horaInicioPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioPrevisto']) . "'" : "NULL";
    $horaFinalPrevisto = isset($jsonEntrada['horaFinalPrevisto']) && $jsonEntrada['horaFinalPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalPrevisto']) . "'" : "NULL";

    $sql = "INSERT INTO tarefa(tituloTarefa, idCliente, idDemanda, idAtendente, idTipoOcorrencia, horaCobrado, Previsto, horaInicioPrevisto, horaFinalPrevisto) VALUES ('$tituloTarefa', $idCliente, $idDemanda, $idAtendente, $idTipoOcorrencia, $horaCobrado, $Previsto, $horaInicioPrevisto, $horaFinalPrevisto)";

    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];


    if (isset($jsonEntrada['Previsto'])) {
        if (in_array($tipoStatusDemanda, $statusTarefa)) {
            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        } else {
            $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        }
    } else {
        $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            fwrite($arquivo, $identificacao . "-SQL->" . $sql23 . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        $atualizar3 = mysqli_query($conexao, $sql3);
        if (!$atualizar && !$atualizar3)
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