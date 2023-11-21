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
    $idDemanda = $jsonEntrada['idDemanda'];
    $idTipoStatus = TIPOSTATUS_REALIZADO;

    //busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];

    $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";


//lucas 22092023 ID 358 modificado o teste para gravar a data quando for tipo encerrado
    if ($statusDemanda == 3) { //se status for do tipo encerrar
        if ($dataFechamento == null) { //e a data for null
            $dataFechamento = 'CURRENT_TIMESTAMP ()'; //grava a data de fechamento
            $sql2 = "UPDATE demanda SET dataFechamento=$dataFechamento, dataAtualizacaoAtendente=CURRENT_TIMESTAMP () WHERE demanda.idDemanda = $idDemanda ";
        }
    } else { 
        if ($dataFechamento != null) { // se for outro status
            $dataFechamento = 'null'; //grava null na data de fechamento
            $sql2 = "UPDATE demanda SET dataFechamento=$dataFechamento, dataAtualizacaoAtendente=CURRENT_TIMESTAMP () WHERE demanda.idDemanda = $idDemanda ";
        }
    }

    
    // Chama a api de comentarios
    if(isset($jsonEntrada['comentario'])){
        echo '__ ESTOU AQUI___';
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idUsuario' => $jsonEntrada['idUsuario'],
            'idCliente' => $jsonEntrada['idCliente'],
            'idDemanda' => $jsonEntrada['idDemanda'],
            'comentario' => $jsonEntrada['comentario'],
            'tipoStatusDemanda' => $jsonEntrada['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_RESPONDIDO

        );
        $comentario = chamaAPI(null, '/services/comentario/cliente', json_encode($apiEntrada), 'PUT');
    }

    // Chama a api de Tarefas
    if(isset($jsonEntrada['idTarefa'])){
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $jsonEntrada['idTarefa'],
            'idDemanda' => $jsonEntrada['idDemanda'],
            'tipoStatusDemanda' => $jsonEntrada['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_PAUSADO
        );
        $tarefas = chamaAPI(null, '/services/tarefas/stop', json_encode($apiEntrada), 'POST');
    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            fwrite($arquivo, $identificacao . "-SQL2->" . $sql2 . "\n");
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