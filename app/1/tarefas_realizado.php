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
    $horaFinalReal = "'" . date('H:i:00') . "'";
    $comentario = isset($jsonEntrada['comentario']) && $jsonEntrada['comentario'] !== "null" && $jsonEntrada['comentario'] !== "" ? "'" . $jsonEntrada['comentario'] . "'" : "null";
       
    //Busca dados de Tarefa    
    $sql_consulta = "SELECT * FROM tarefa WHERE idTarefa = $idTarefa";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    $idDemanda = isset($row_consulta["idDemanda"])  && $row_consulta["idDemanda"] !== ""  ? "'". $row_consulta["idDemanda"]."'"  : "null";
    $horaCobrado = isset($row_consulta["horaCobrado"])  && $row_consulta["horaCobrado"] !== "" && $row_consulta["horaCobrado"] !== "null" ? "'". $row_consulta["horaCobrado"]."'"  : "null";
    $horaInicioRealTarefa = $row_consulta["horaInicioReal"];

    $statusStart = array(
        TIPOSTATUS_FILA,
        TIPOSTATUS_PAUSADO,
        TIPOSTATUS_RETORNO,
        TIPOSTATUS_RESPONDIDO,
        TIPOSTATUS_AGENDADO
    );

    if ($idDemanda !== "null") {
        //Se tiver demanda, vai ser atribuido novo valor para variavel $tipoStatusDemanda
        $sql_consulta = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $tipoStatusDemanda = $row_consulta["idTipoStatus"];
        $tipoStatusDemanda = $row_consulta["idTipoStatus"];
        $idUsuario = $row_consulta["idAtendente"];
    }

    //ação : REALIZADO
    if ($jsonEntrada['acao'] == "realizado") {
        
        if ($horaCobrado === 'null') {
            $horaCobrado = "'" . '00:31:00' . "'";  
        } 
      
        $sql = "UPDATE tarefa SET dataReal = $dataReal, horaInicioReal = $horaInicioReal , horaFinalReal = $horaFinalReal , horaCobrado = $horaCobrado WHERE idTarefa = $idTarefa";

        if ($idDemanda !== "null") {
            $idTipoStatus = TIPOSTATUS_PAUSADO;
            //Busca dados Tipostatus    
            $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $posicao = $row_consulta["mudaPosicaoPara"];
            $statusDemanda = $row_consulta["mudaStatusPara"];

            $sql_update_demanda = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        }
    }


    //ação : START
    if ($jsonEntrada['acao'] == "start") {
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

            $sql_update_demanda = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP() ";
                if (in_array($tipoStatusDemanda, $statusStart)) {
                    $sql_update_demanda = $sql_update_demanda . ", posicao=$posicao, idTipoStatus=$idTipoStatus, statusDemanda=$statusDemanda ";
                }
            $sql_update_demanda = $sql_update_demanda . "  WHERE idDemanda = $idDemanda";
        }
    }

    //ação : STOP
    if ($jsonEntrada['acao'] == "stop") {

        if ($horaCobrado === "null") {
            // remove aspas da variavel $horasFinalReal para ser instanciada como objeto DateTime
            $horaFinalReal = date('H:i:00');
            $horaFinalRealObj = new DateTime($horaFinalReal);
            $horaInicioRealTarefaObj = new DateTime($horaInicioRealTarefa);
            $interval = $horaInicioRealTarefaObj->diff($horaFinalRealObj);
            $horaCobrado_comparacao = $interval->format('%H:%I:%S');
            $horaCobrado = "'" . $interval->format('%H:%I:%S') . "'";

            if (strtotime($horaCobrado_comparacao) < strtotime('00:30:00')) {
                $horaCobrado = '00:30:00';
                $horaCobrado = "'" . $horaCobrado . "'";
            }
            // adiciona aspas da variavel $horasFinalReal para ser usada no UPDATE
            $horaFinalReal = "'" . date('H:i:00') . "'";
        } 

        $sql = "UPDATE tarefa SET horaFinalReal = $horaFinalReal, horaCobrado = $horaCobrado  WHERE idTarefa = $idTarefa";

        if ($idDemanda !== "null") {
            $idTipoStatus = TIPOSTATUS_PAUSADO;
            //Busca dados Tipostatus    
            $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $posicao = $row_consulta["mudaPosicaoPara"];
            $statusDemanda = $row_consulta["mudaStatusPara"];

            $sql_update_demanda = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP() ";
                if ($tipoStatusDemanda == TIPOSTATUS_FAZENDO) {
                    $sql_update_demanda = $sql_update_demanda . ",idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda ";
                }
            $sql_update_demandal = $sql_update_demanda . "  WHERE idDemanda = $idDemanda";

        }
    }

    //ação : ENTREGUE
    if ($jsonEntrada['acao'] == "entregue") {

        if ($horaCobrado === "null") {
            // remove aspas da variavel $horasFinalReal para ser instanciada como objeto DateTime
            $horaFinalReal = date('H:i:00');
            $horaFinalRealObj = new DateTime($horaFinalReal);
            $horaInicioRealTarefaObj = new DateTime($horaInicioRealTarefa);
            $interval = $horaInicioRealTarefaObj->diff($horaFinalRealObj);
            $horaCobrado_comparacao = $interval->format('%H:%I:%S');
            $horaCobrado = "'" . $interval->format('%H:%I:%S') . "'";

            if (strtotime($horaCobrado_comparacao) < strtotime('00:30:00')) {
                $horaCobrado = '00:30:00';
                $horaCobrado = "'" . $horaCobrado . "'";
            }
            // adiciona aspas da variavel $horasFinalReal para ser usada no UPDATE
            $horaFinalReal = "'" . date('H:i:00') . "'";
        }

        $sql = "UPDATE tarefa SET horaFinalReal = $horaFinalReal, horaCobrado = $horaCobrado  WHERE idTarefa = $idTarefa";

        if ($idDemanda !== "null") {
            $idTipoStatus = TIPOSTATUS_REALIZADO;
            //Busca dados Tipostatus    
            $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $posicao = $row_consulta["mudaPosicaoPara"];
            $statusDemanda = $row_consulta["mudaStatusPara"];

            $sql_update_demanda = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), dataFechamento = CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";

            if ($comentario !== "null") {
                $sql_insert_comentario = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda, $comentario, $idUsuario, CURRENT_TIMESTAMP())";
            }
        }
        
    }



    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            if (isset($sql_update_demanda)) {
                fwrite($arquivo, $identificacao . "-SQL_UPDATE_DEMANDA->" . $sql_update_demanda . "\n");
            }
            if (isset($sql_insert_comentario)) {
                fwrite($arquivo, $identificacao . "- SQL_INSERT_COMENTARIOS->" . $sql_insert_comentario . "\n");
            }
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));
        if (isset($sql_update_demanda)) {
            $atualizar2 = mysqli_query($conexao, $sql_update_demanda);
            if (!$atualizar2)
                throw new Exception(mysqli_error($conexao));
            }
        if (isset($sql_insert_comentario)) {
            $atualizar3 = mysqli_query($conexao, $sql_insert_comentario);
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
