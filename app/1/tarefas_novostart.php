<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "tarefas_novostart";
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
    
    $idAtendente = $jsonEntrada['idAtendente'];
    $idCliente = isset($jsonEntrada['idCliente']) && $jsonEntrada['idCliente'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idCliente']) : "NULL";
    $idTipoOcorrencia = isset($jsonEntrada['idTipoOcorrencia']) && $jsonEntrada['idTipoOcorrencia'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idTipoOcorrencia']) : "NULL";
    $tipoStatusDemanda = isset($jsonEntrada['tipoStatusDemanda']) && $jsonEntrada['tipoStatusDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['tipoStatusDemanda']) : "NULL";
    $idDemanda = isset($jsonEntrada['idDemanda']) && $jsonEntrada['idDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idDemanda']) : "NULL";
    $horaCobrado = isset($jsonEntrada['horaCobrado']) && $jsonEntrada['horaCobrado'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaCobrado']) . "'" : "NULL";
    $Previsto = isset($jsonEntrada['Previsto']) && $jsonEntrada['Previsto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['Previsto']) . "'" : "NULL";
    $horaInicioPrevisto = isset($jsonEntrada['horaInicioPrevisto']) && $jsonEntrada['horaInicioPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioPrevisto']) . "'" : "NULL";
    $horaFinalPrevisto = isset($jsonEntrada['horaFinalPrevisto']) && $jsonEntrada['horaFinalPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalPrevisto']) . "'" : "NULL";

    if(isset($jsonEntrada['tituloTarefa'])){
        $tituloTarefa = $jsonEntrada['tituloTarefa'];
    }
    if(($Previsto) != "NULL" && $tituloTarefa == ''){
        $tituloTarefa = $jsonEntrada['tituloDemanda'];
    }
        
    
    $sql = "INSERT INTO tarefa(tituloTarefa, idCliente, idDemanda, idAtendente, idTipoOcorrencia, horaCobrado, Previsto, horaInicioPrevisto, horaFinalPrevisto, horaInicioReal, dataReal) VALUES ('$tituloTarefa', $idCliente, $idDemanda, $idAtendente, $idTipoOcorrencia, $horaCobrado, $Previsto, $horaInicioPrevisto, $horaFinalPrevisto,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP())";

    if (isset($jsonEntrada['Previsto'])) {
        $idTipoStatus = TIPOSTATUS_AGENDADO;

        // busca dados tipostatus    
        $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $posicao = $row["mudaPosicaoPara"];
        $statusDemanda = $row["mudaStatusPara"];

        if (in_array($tipoStatusDemanda, $statusTarefa)) {
            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        } else {
            $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        }
    }

    $idTipoStatus = TIPOSTATUS_FAZENDO;
    $sql4 = "UPDATE `demanda` SET `idTipoStatus`= $idTipoStatus WHERE idDemanda = $idDemanda";
    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 2) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            fwrite($arquivo, $identificacao . "-SQL3->" . $sql3 . "\n");
            fwrite($arquivo, $identificacao . "-SQL4->" . $sql4 . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        $atualizar3 = mysqli_query($conexao, $sql3);
        $atualizar4 = mysqli_query($conexao, $sql4);
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



?>