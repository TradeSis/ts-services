<?php
//lucas 22092023 ID 358 Demandas/Comentarios 
//gabriel 220323
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "demanda_atualizar";
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
if (isset($jsonEntrada['idDemanda'])) {

    //REALIZADO
    if ($jsonEntrada['acao'] == "realizado") {
        $idDemanda = $jsonEntrada['idDemanda'];
        $idUsuario = $jsonEntrada['idUsuario'];
        $idTarefa = $jsonEntrada['idTarefa'];
        $idTarefa = isset($jsonEntrada['idTarefa'])  && $jsonEntrada['idTarefa'] !== ""        ?   $jsonEntrada['idTarefa']    : "null";
        $comentario = isset($jsonEntrada['comentario']) && $jsonEntrada['comentario'] !== "null" && $jsonEntrada['comentario'] !== "" ? "'" . $jsonEntrada['comentario'] . "'" : "null";
        $idTipoStatus = TIPOSTATUS_REALIZADO;

        //busca dados tipostatus    
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";

        //busca data de fechamento atual
        $sql_consulta = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $dataFechamento = $row_consulta["dataFechamento"];


        //lucas 22092023 ID 358 modificado o teste para gravar a data quando for tipo encerrado
        if ($statusDemanda == 3) { //se status for do tipo encerrar
            if ($dataFechamento == null) { //e a data for null
                $dataFechamento = 'CURRENT_TIMESTAMP ()'; //grava a data de fechamento
                $sql2 = "UPDATE demanda SET dataFechamento = $dataFechamento, dataAtualizacaoAtendente=CURRENT_TIMESTAMP () WHERE demanda.idDemanda = $idDemanda ";
            }
        } else {
            if ($dataFechamento != null) { // se for outro status
                $dataFechamento = 'null'; //grava null na data de fechamento
                $sql2 = "UPDATE demanda SET dataFechamento=$dataFechamento, dataAtualizacaoAtendente=CURRENT_TIMESTAMP () WHERE demanda.idDemanda = $idDemanda ";
            }
        }

        if ($comentario !== "null") {
            $sql3 = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda, $comentario, $idUsuario, CURRENT_TIMESTAMP())";
        }

        // Chama a api de Tarefas
        if ($idTarefa !== "null") {
            $apiEntrada = array(
                'idEmpresa' => $idEmpresa,
                'idTarefa' => $jsonEntrada['idTarefa'],
                'idDemanda' => $jsonEntrada['idDemanda'],
                'tipoStatusDemanda' => $jsonEntrada['tipoStatusDemanda'],
                'idTipoStatus' => TIPOSTATUS_PAUSADO,
                'acao' => 'stop'
            );
            $tarefas = chamaAPI(null, '/services/tarefas/realizado', json_encode($apiEntrada), 'POST');
        }

    }


    //RETORNAR
    if ($jsonEntrada['acao'] == "retornar") {

        $idDemanda = $jsonEntrada['idDemanda'];
        $comentario = $jsonEntrada['comentario'];
        $comentario = isset($jsonEntrada['comentario']) && $jsonEntrada['comentario'] !== "null" && $jsonEntrada['comentario'] !== "" ? "'" . $jsonEntrada['comentario'] . "'" : "null";
        $idUsuario = $jsonEntrada['idUsuario'];
        $idCliente = $jsonEntrada['idCliente'];
        $idTipoStatus = TIPOSTATUS_RETORNO;

        // busca dados tipostatus    
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataFechamento=NULL, statusDemanda=$statusDemanda, dataAtualizacaoCliente=CURRENT_TIMESTAMP(), QtdRetornos=QtdRetornos+1 WHERE idDemanda = $idDemanda;";

        if ($comentario !== "null") {
            $sql2 = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda, $comentario ,$idUsuario,CURRENT_TIMESTAMP())";
        }
    }


    //VALIDAR
    if ($jsonEntrada['acao'] == "validar") {

        $idDemanda = $jsonEntrada['idDemanda'];
        $comentario = isset($jsonEntrada['comentario']) && $jsonEntrada['comentario'] !== "null" && $jsonEntrada['comentario'] !== "" ? "'" . $jsonEntrada['comentario'] . "'" : "null";
        $idUsuario = $jsonEntrada['idUsuario'];
        $idCliente = $jsonEntrada['idCliente'];
        $idTipoStatus = TIPOSTATUS_VALIDADO;

        // busca dados tipostatus    
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        //busca data de fechamento atual
        $sql_consulta = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $dataFechamento = $row_consulta["dataFechamento"];

        if ($dataFechamento == null) {
            $dataFechamento = 'CURRENT_TIMESTAMP ()';
        } else {
            $dataFechamento = "'" . $dataFechamento . "'";
        }
        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoCliente=CURRENT_TIMESTAMP(),dataFechamento = $dataFechamento, statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";

        if ($comentario !== "null") {
            $sql2 = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda,'$comentario',$idUsuario,CURRENT_TIMESTAMP())";
        }
    }

    //RETORNAR
    if ($jsonEntrada['acao'] == "solicitar") {

        $idDemanda = $jsonEntrada['idDemanda'];
        $comentario = isset($jsonEntrada['comentario']) && $jsonEntrada['comentario'] !== "null" && $jsonEntrada['comentario'] !== "" ? "'" . $jsonEntrada['comentario'] . "'" : "null";
        $idUsuario = $jsonEntrada['idUsuario'];
        $idCliente = $jsonEntrada['idCliente'];
        $idAtendente = $jsonEntrada['idAtendente']; //****/
        $idTipoStatus = TIPOSTATUS_AGUARDANDOSOLICITANTE;


        $sql = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda,$comentario,$idUsuario,CURRENT_TIMESTAMP())";


        // busca dados tipostatus    
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        //lucas 22092023 ID 358 Adicionado idAtendente
        $sql2 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, idAtendente=$idAtendente , dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";

    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            if (isset($sql2)) {
                fwrite($arquivo, $identificacao . "-SQL2->" . $sql2 . "\n");
            }
            if (isset($sql3)) {
                fwrite($arquivo, $identificacao . "-SQL3->" . $sql3 . "\n");
            }
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        if (isset($sql2)) {
            $atualizar2 = mysqli_query($conexao, $sql2);
            if (!$atualizar2)
                throw new Exception(mysqli_error($conexao));
        }
        if (isset($sql3)) {
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