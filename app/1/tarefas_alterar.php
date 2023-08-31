<?php
// helio 12072023 - ajustes de horas
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "tarefas_alterar";
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

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $idDemandaSelect = $jsonEntrada['idDemandaSelect'];
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $idAtendente = $jsonEntrada['idAtendente'];

    $idDemanda = isset($jsonEntrada['idDemanda']) && $jsonEntrada['idDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idDemanda']) : "NULL";
    $idTipoOcorrencia = isset($jsonEntrada['idTipoOcorrencia']) && $jsonEntrada['idTipoOcorrencia'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idTipoOcorrencia']) : "NULL";
    $tipoStatusDemanda = isset($jsonEntrada['tipoStatusDemanda']) && $jsonEntrada['tipoStatusDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['tipoStatusDemanda']) : "NULL";
    $dataReal = isset($jsonEntrada['dataReal']) && $jsonEntrada['dataReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataReal']) . "'" : "NULL";
    $horaInicioReal = isset($jsonEntrada['horaInicioReal']) && $jsonEntrada['horaInicioReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioReal']) . "'" : "NULL";
    $horaFinalReal = isset($jsonEntrada['horaFinalReal']) && $jsonEntrada['horaFinalReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalReal']) . "'" : "NULL";
    $horaCobrado = isset($jsonEntrada['horaCobrado']) && $jsonEntrada['horaCobrado'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaCobrado']) . "'" : "NULL";
    $Previsto = isset($jsonEntrada['Previsto']) && $jsonEntrada['Previsto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['Previsto']) . "'" : "NULL";
    $horaInicioPrevisto = isset($jsonEntrada['horaInicioPrevisto']) && $jsonEntrada['horaInicioPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioPrevisto']) . "'" : "NULL";
    $horaFinalPrevisto = isset($jsonEntrada['horaFinalPrevisto']) && $jsonEntrada['horaFinalPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalPrevisto']) . "'" : "NULL";


    if ($idDemandaSelect !== null) {
        // busca dados idCliente/Demanda
        $sql2 = "SELECT * FROM demanda WHERE idDemanda = $idDemandaSelect";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $idCliente = $row["idCliente"];


        $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`=$horaCobrado,
    `dataReal`=$dataReal, `horaInicioReal`=$horaInicioReal, `horaFinalReal`=$horaFinalReal, `idDemanda`=$idDemandaSelect, `idCliente`=$idCliente,
    `Previsto`=$Previsto, `horaInicioPrevisto`=$horaInicioPrevisto, `horaFinalPrevisto`=$horaFinalPrevisto 
    WHERE `idTarefa` = $idTarefa";
    } else {
        $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`=$horaCobrado,
        `dataReal`=$dataReal, `horaInicioReal`=$horaInicioReal, `horaFinalReal`=$horaFinalReal,
        `Previsto`=$Previsto, `horaInicioPrevisto`=$horaInicioPrevisto, `horaFinalPrevisto`=$horaFinalPrevisto 
        WHERE `idTarefa` = $idTarefa";
    }

    if (isset($jsonEntrada['idDemanda'])) {
        if (isset($jsonEntrada['Previsto'])) {
            $idTipoStatus = TIPOSTATUS_AGENDADO;

            // busca dados tipostatus    
            $sql4 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar4 = mysqli_query($conexao, $sql4);
            $row = mysqli_fetch_array($buscar4, MYSQLI_ASSOC);
            $posicao = $row["mudaPosicaoPara"];
            $statusDemanda = $row["mudaStatusPara"];

            if (in_array($tipoStatusDemanda, $statusTarefa)) {
                $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
            } else {
                $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
            }
        }
    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 2) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            fwrite($arquivo, $identificacao . "-SQL3->" . $sql3 . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        $atualizar3 = mysqli_query($conexao, $sql3);
        if (!$atualizar || !$atualizar3)
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