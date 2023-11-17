<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "tarefas_stop";
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

date_default_timezone_set('America/Sao_Paulo');
$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $horaFinalReal = date('H:i:00');
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $idDemanda = isset($jsonEntrada['idDemanda']) && $jsonEntrada['idDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['idDemanda']) : "NULL";
    $tipoStatusDemanda = isset($jsonEntrada['tipoStatusDemanda']) && $jsonEntrada['tipoStatusDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['tipoStatusDemanda']) : "NULL";

    // busca horaCobrado Tarefa    
    $sql4 = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
    $buscar4 = mysqli_query($conexao, $sql4);
    $row = mysqli_fetch_array($buscar4, MYSQLI_ASSOC);
    $horaInicioRealTarefa = $row["horaInicioReal"];
    $horaCobradoTarefa = $row["horaCobrado"];

    if ($horaCobradoTarefa == null) {
        $horaFinalRealObj = new DateTime($horaFinalReal);
        $horaInicioRealTarefaObj = new DateTime($horaInicioRealTarefa);

        $interval = $horaInicioRealTarefaObj->diff($horaFinalRealObj);
        $horaCobrado = $interval->format('%H:%I:%S');

        if (strtotime($horaCobrado) < strtotime('00:30:00')) {
            $horaCobrado = '00:30:00';
        }
        $sql = "UPDATE `tarefa` SET `horaFinalReal`='$horaFinalReal', `horaCobrado`='$horaCobrado' WHERE idTarefa = $idTarefa";
    } else {
        $sql = "UPDATE `tarefa` SET `horaFinalReal`='$horaFinalReal' WHERE idTarefa = $idTarefa";
    }


    if ($idDemanda !== null) {
        // busca dados tipostatus    
        $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $posicao = $row["mudaPosicaoPara"];
        $statusDemanda = $row["mudaStatusPara"];

        if ($tipoStatusDemanda == TIPOSTATUS_FAZENDO) {
            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        } else {
            $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda";
        }
    }


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
        $atualizar3 = mysqli_query($conexao, $sql3);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
        if (!$atualizar3)
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