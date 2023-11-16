<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "tarefas_realizado";
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
    $dataReal = date('Y-m-d');
    $horaInicioReal = date('H:i:00');
    $horaFinalReal = date('H:i:00');
    
    //Verifica se a tarefa tem Demanda, se tiver é atribuido um id para Varivel de $idDemanda
    $sql2 = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $idDemanda = $row["idDemanda"];
    if($idDemanda === null){
        $idDemanda = null;
    }

    if ($idDemanda !== null) { 
    //Se tiver demanda, vai ser atribuido novo valor para variavel $tipoStatusDemanda
        $sql2 = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $tipoStatusDemanda = $row["idTipoStatus"]; 
    }
    $statusStart = array(
        TIPOSTATUS_FILA,
        TIPOSTATUS_PAUSADO,
        TIPOSTATUS_RETORNO,
        TIPOSTATUS_RESPONDIDO,
        TIPOSTATUS_AGENDADO
    );

    //Teste ação Realizado
    if($jsonEntrada['acao'] == "realizado"){
    // busca horaCobrado Tarefa    
    $sql4 = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
    $buscar4 = mysqli_query($conexao, $sql4);
    $row = mysqli_fetch_array($buscar4, MYSQLI_ASSOC);
    $horaCobradoTarefa = $row["horaCobrado"];

    if ($horaCobradoTarefa == null || $horaCobradoTarefa == '00:00:00') {
        $horaCobrado = '00:30:00';
        $sql = "UPDATE `tarefa` SET `dataReal`='$dataReal', `horaInicioReal`='$horaInicioReal', `horaFinalReal`='$horaFinalReal', `horaCobrado`='$horaCobrado' WHERE idTarefa = $idTarefa";
    } else {
        $sql = "UPDATE `tarefa` SET `dataReal`='$dataReal', `horaInicioReal`='$horaInicioReal', `horaFinalReal`='$horaFinalReal' WHERE idTarefa = $idTarefa";
    }


    if ($idDemanda !== null) {
        $idTipoStatus = TIPOSTATUS_PAUSADO;
        // busca dados tipostatus    
        $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $posicao = $row["mudaPosicaoPara"];
        $statusDemanda = $row["mudaStatusPara"];

        $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
    }
}

//Teste ação Start
if($jsonEntrada['acao'] == "start"){
    // lucas id654 - Adicionado dataOrdem e horaInicioReal
    $dataOrdem = $dataReal;
    $horaInicioOrdem = $horaInicioReal;
    
    $sql = "UPDATE `tarefa` SET `horaInicioReal`='$horaInicioReal', `dataReal`='$dataReal',`dataOrdem`='$dataOrdem', `horaInicioOrdem`='$horaInicioOrdem' WHERE idTarefa = $idTarefa";
    
    if ($idDemanda !== null) {
    $idTipoStatus = TIPOSTATUS_FAZENDO;
    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];

        if (in_array($tipoStatusDemanda, $statusStart)) {
            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        } else {
            $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda";
        }
    }
}

//Teste ação Stop
if($jsonEntrada['acao'] == "stop"){
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
        $idTipoStatus = TIPOSTATUS_PAUSADO;
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
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));
        if(isset($sql3)){
            $atualizar3 = mysqli_query($conexao, $sql3);
            if (!$atualizar3)
            throw new Exception(mysqli_error($conexao));
        }
        
        

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
