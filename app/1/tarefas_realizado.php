<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
/*
Exemplo de entrada :
{"idEmpresa":"1","idTarefa":"1360","acao":"start"}
{"idEmpresa":"1","idTarefa":"1363","acao":"stop"}
{"idEmpresa":"1","idTarefa":"1364","acao":"realizado"}
*/

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
    $dataReal = "'" . date('Y-m-d') . "'";
    $horaInicioReal = "'" . date('H:i:00') . "'";
    $horaFinalReal = "'" .date('H:i:00') . "'";
    
        //Verifica se a tarefa tem Demanda
        $sql_consulta = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $idDemanda = $row_consulta["idDemanda"];
        if($idDemanda === null){
            $idDemanda = "null";
        }

    //ação : REALIZADO
    if($jsonEntrada['acao'] == "realizado"){
        //Busca horaCobrado de Tarefa    
        $sql_consulta = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $horaCobradoTarefa = $row_consulta["horaCobrado"];
        

        if ($horaCobradoTarefa == null) {
            $horaCobrado = "'" .'00:30:00' . "'";
            $sql = "UPDATE tarefa SET dataReal = $dataReal, horaInicioReal = $horaInicioReal , horaFinalReal = $horaFinalReal , horaCobrado = $horaCobrado WHERE idTarefa = $idTarefa";
        } else {
            $sql = "UPDATE tarefa SET dataReal = $dataReal , horaInicioReal = $horaInicioReal , horaFinalReal = $horaFinalReal WHERE idTarefa = $idTarefa";
        }

        if ($idDemanda !== "null") {
            $idTipoStatus = TIPOSTATUS_PAUSADO;
            //Busca dados Tipostatus    
            $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $posicao = $row_consulta["mudaPosicaoPara"];
            $statusDemanda = $row_consulta["mudaStatusPara"];

            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        }
    }

  if ($idDemanda !== "null") { 
    //Se tiver demanda, vai ser atribuido novo valor para variavel $tipoStatusDemanda
        $sql_consulta = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $tipoStatusDemanda = $row_consulta["idTipoStatus"]; 
    }
    $statusStart = array(
        TIPOSTATUS_FILA,
        TIPOSTATUS_PAUSADO,
        TIPOSTATUS_RETORNO,
        TIPOSTATUS_RESPONDIDO,
        TIPOSTATUS_AGENDADO
    );

    //ação : START
    if($jsonEntrada['acao'] == "start"){
        // lucas id654 - Adicionado dataOrdem e horaInicioReal
        $dataOrdem = $dataReal;
        $horaInicioOrdem = $horaInicioReal;
    
        $sql = "UPDATE tarefa SET horaInicioReal = $horaInicioReal, dataReal = $dataReal , dataOrdem = $dataOrdem, horaInicioOrdem = $horaInicioOrdem  WHERE idTarefa = $idTarefa";
    
        if ($idDemanda !== "null") {
            $idTipoStatus = TIPOSTATUS_FAZENDO;
            //Busca dados Tipostatus    
            $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $posicao = $row_consulta["mudaPosicaoPara"];
            $statusDemanda = $row_consulta["mudaStatusPara"];

            if (in_array($tipoStatusDemanda, $statusStart)) {
                $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
            } else {
                $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda";
            }
        }
    }

    //ação : STOP
    if($jsonEntrada['acao'] == "stop"){
        // busca horaCobrado Tarefa    
        $sql_consulta = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $horaInicioRealTarefa = $row_consulta["horaInicioReal"];
        $horaCobradoTarefa = $row_consulta["horaCobrado"];
        if($horaCobradoTarefa === null){
            $horaCobradoTarefa = "null";
        }
    
        if ($horaCobradoTarefa === "null") {
            // remove aspas da variavel $horasFinalReal para ser instanciada como objeto DateTime
            $horaFinalReal = date('H:i:00');
            $horaFinalRealObj = new DateTime($horaFinalReal);
            $horaInicioRealTarefaObj = new DateTime($horaInicioRealTarefa);
            $interval = $horaInicioRealTarefaObj->diff($horaFinalRealObj);
            $horaCobrado_comparacao = $interval->format('%H:%I:%S');
            $horaCobrado = "'" . $interval->format('%H:%I:%S') . "'";
        
            if (strtotime($horaCobrado_comparacao) < strtotime('00:30:00')) {
                $horaCobrado = '00:30:00';
                $horaCobrado = "'" .$horaCobrado . "'";
            }
        
            // adiciona aspas da variavel $horasFinalReal para ser usada no UPDATE
            $horaFinalReal = "'" .date('H:i:00') . "'";

            $sql = "UPDATE tarefa SET horaFinalReal = $horaFinalReal, horaCobrado = $horaCobrado  WHERE idTarefa = $idTarefa";
        } else {
            $sql = "UPDATE tarefa SET horaFinalReal = $horaFinalReal WHERE idTarefa = $idTarefa";
        }

        if ($idDemanda !== "null") {
            $idTipoStatus = TIPOSTATUS_PAUSADO;
            //Busca dados Tipostatus    
            $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $posicao = $row_consulta["mudaPosicaoPara"];
            $statusDemanda = $row_consulta["mudaStatusPara"];

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
