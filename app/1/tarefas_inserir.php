<?php
 //Lucas 10112023 ID 965 - Melhorias Tarefas
// lucas id654 - Melhorias Tarefas
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

/* 
Exemplo de entrada
{
    "idEmpresa": "1",
    "tituloTarefa": "teste",
    "idCliente": "10",
    "idDemanda": "661",
    "idAtendente": "14",
    "idTipoOcorrencia": "8",
    "Previsto": "",
    "horaInicioPrevisto": "",
    "horaFinalPrevisto": "",
    "acao": "start"
} */

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
    TIPOSTATUS_RESPONDIDO
);
$statusStart = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_PAUSADO,
    TIPOSTATUS_RETORNO,
    TIPOSTATUS_RESPONDIDO,
    TIPOSTATUS_AGENDADO
);

date_default_timezone_set('America/Sao_Paulo');
$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);

if (isset($jsonEntrada['idEmpresa'])) {

    $tipoStatusDemanda = null;

    $idDemanda = isset($jsonEntrada['idDemanda']) && $jsonEntrada['idDemanda'] !== "" ? 
    mysqli_real_escape_string($conexao, $jsonEntrada['idDemanda']) : "null";
    //Se tiver demanda, vai ser atribuido novo valor para variavel $tipoStatusDemanda
    if ($idDemanda != 'null') { 
        $sql2 = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $tipoStatusDemanda = $row["idTipoStatus"]; 
    }
    
    $idAtendente = $jsonEntrada['idAtendente'];

    $idCliente = isset($jsonEntrada['idCliente']) && $jsonEntrada['idCliente'] !== "" ? 
    mysqli_real_escape_string($conexao, $jsonEntrada['idCliente']) : "null";
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];

    $Previsto = " ";
    if(isset($jsonEntrada['Previsto'])){
        $Previsto = $jsonEntrada['Previsto'];
    }
    $horaInicioPrevisto = " ";
    if(isset($jsonEntrada['horaInicioPrevisto'])){
        $horaInicioPrevisto = $jsonEntrada['horaInicioPrevisto'];
    }
    $horaFinalPrevisto = " ";
    if(isset($jsonEntrada['horaFinalPrevisto'])){
        $horaFinalPrevisto = $jsonEntrada['horaFinalPrevisto'];
    }
    $acao = $jsonEntrada['acao'];


    if (isset($jsonEntrada['Previsto'])) {
        $idTipoStatus = TIPOSTATUS_AGENDADO;
    }
    if ($acao == 'start') {
        $idTipoStatus = TIPOSTATUS_FAZENDO;
        $dataReal = date('Y-m-d');
        $horaInicioReal = date('H:i:00');
    }
    if (isset($jsonEntrada['tituloTarefa'])) {
        $tituloTarefa = $jsonEntrada['tituloTarefa'];
    }
 
    if ($acao == 'start') {
        $dataOrdem = $dataReal;
        $horaInicioOrdem = $horaInicioReal;
        
    } else {
        $dataOrdem = $Previsto;
        $horaInicioOrdem = $horaInicioPrevisto;
    }
   
  
    $sql = "INSERT INTO tarefa(tituloTarefa, idCliente, idDemanda, idAtendente, idTipoOcorrencia, Previsto, horaInicioPrevisto, horaFinalPrevisto, 
                        horaInicioReal, dataReal,dataOrdem,horaInicioOrdem) 
           VALUES ('$tituloTarefa', $idCliente, $idDemanda, $idAtendente, $idTipoOcorrencia, '$Previsto', '$horaInicioPrevisto', '$horaFinalPrevisto', 
                        '$horaInicioReal', '$dataReal', '$dataOrdem', '$horaInicioOrdem')";

    if ($idDemanda != 'null') {
        // busca dados tipostatus    
        $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $posicao = $row["mudaPosicaoPara"];
        $statusDemanda = $row["mudaStatusPara"];

        if (isset($jsonEntrada['Previsto']) && in_array($tipoStatusDemanda, $statusTarefa)) {
            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        }
        if (($acao == 'start') && in_array($tipoStatusDemanda, $statusStart)) {
            $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        } else {
            $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        }
    }
    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 2) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            if(isset($sql3)){
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



?>