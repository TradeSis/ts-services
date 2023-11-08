<?php
// Lucas 08112023 - id965 Melhorias Tarefas
// lucas id654 - Melhorias Tarefas
//Gabriel 11102023 ID 596 mudanças em agenda e tarefas
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
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    
    $tipoStatusDemanda = isset($jsonEntrada['tipoStatusDemanda']) && $jsonEntrada['tipoStatusDemanda'] !== "" ? mysqli_real_escape_string($conexao, $jsonEntrada['tipoStatusDemanda']) : "NULL";
    $dataReal = isset($jsonEntrada['dataReal']) && $jsonEntrada['dataReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataReal']) . "'" : "NULL";
    $horaInicioReal = isset($jsonEntrada['horaInicioReal']) && $jsonEntrada['horaInicioReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioReal']) . "'" : "NULL";
    $horaFinalReal = isset($jsonEntrada['horaFinalReal']) && $jsonEntrada['horaFinalReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalReal']) . "'" : "NULL";
    // Lucas 08112023 - id965 removido horascobrado
    $Previsto = isset($jsonEntrada['Previsto']) && $jsonEntrada['Previsto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['Previsto']) . "'" : "NULL";
    $horaInicioPrevisto = isset($jsonEntrada['horaInicioPrevisto']) && $jsonEntrada['horaInicioPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioPrevisto']) . "'" : "NULL";
    $horaFinalPrevisto = isset($jsonEntrada['horaFinalPrevisto']) && $jsonEntrada['horaFinalPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalPrevisto']) . "'" : "NULL";
    $descricao = isset($jsonEntrada['descricao']) && $jsonEntrada['descricao'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['descricao']) . "'" : "NULL";
    
    //Gabriel 11102023 ID 596 adicionado idAtendenteSelect, idClienteSelect e descricao
    $idTipoOcorrencia = isset($jsonEntrada['idTipoOcorrencia']) && $jsonEntrada['idTipoOcorrencia'] !== NULL ? mysqli_real_escape_string($conexao, $jsonEntrada['idTipoOcorrencia']) : "NULL";
    $idDemanda = isset($jsonEntrada['idDemanda']) && $jsonEntrada['idDemanda'] !== NULL ? mysqli_real_escape_string($conexao, $jsonEntrada['idDemanda']) : "NULL";
    $idAtendente = isset($jsonEntrada['idAtendente']) && $jsonEntrada['idAtendente'] !== NULL ? mysqli_real_escape_string($conexao, $jsonEntrada['idAtendente']) : "NULL";
    $idCliente = isset($jsonEntrada['idCliente']) && $jsonEntrada['idCliente'] !== NULL ? mysqli_real_escape_string($conexao, $jsonEntrada['idCliente']) : "NULL";

    // lucas id654 - Adicionado campos de dataOrdem e horaInicioOrdem
    if($jsonEntrada['dataReal'] == NULL){
        $dataOrdem = $Previsto;
        $horaInicioOrdem = $horaInicioPrevisto;
    }else{ 
        $dataOrdem = $dataReal;
        $horaInicioOrdem = $horaInicioReal;
    } 

    $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', 
        `dataReal`=$dataReal, `horaInicioReal`=$horaInicioReal, `horaFinalReal`=$horaFinalReal, 
        `Previsto`=$Previsto, `horaInicioPrevisto`=$horaInicioPrevisto, `horaFinalPrevisto`=$horaFinalPrevisto, `descricao`=$descricao, `dataOrdem`=$dataOrdem, `horaInicioOrdem`=$horaInicioOrdem";

    if (isset($jsonEntrada['idDemanda']) && $jsonEntrada['idDemanda'] !== NULL) {
        // busca dados idCliente/Demanda
        $sql2 = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $idCliente = $row["idCliente"];
        $sql = $sql . ", `idDemanda`=$idDemanda, `idCliente`=$idCliente";
    }
    //Gabriel 23102023 novo modelo de sql para alterar
    if (isset($jsonEntrada['idAtendente']) && $jsonEntrada['idAtendente'] !== NULL) {
        $sql = $sql . ", `idAtendente`=$idAtendente";
    }
    if (isset($jsonEntrada['idTipoOcorrencia']) && $jsonEntrada['idTipoOcorrencia'] !== NULL) {
        $sql = $sql . ", `idTipoOcorrencia`=$idTipoOcorrencia";
    }
    if (isset($jsonEntrada['idCliente']) && $jsonEntrada['idCliente'] !== NULL && $jsonEntrada['idDemanda'] == NULL) {
        $sql = $sql . ", `idCliente`=$idCliente";
    }
        
    $sql = $sql . " WHERE `idTarefa` = $idTarefa";

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