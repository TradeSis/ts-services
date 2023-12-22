<?php
// Lucas 10032023 - pequeno ajuste ao montar o slq, faltava uma virgula de pois de descricao='$descricao',
// gabriel 06032023 11:25 alteração de descricao demanda
// gabriel 02032023 12:13 alteração de titulo demanda
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "demanda_alterar";
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

    if ($jsonEntrada['acao'] == "visaocli") {  //VISAO CLIENTE
        $sql = "UPDATE demanda SET prioridade = " . $jsonEntrada['prioridade'] ." ";
    } 
    
    if ($jsonEntrada['acao'] == null) {  

            $tituloDemanda = "'" . $jsonEntrada['tituloDemanda'] . "'";
            // lucas 06122023 id715  - removido descricao
            $prioridade = $jsonEntrada['prioridade'];
            //lucas 28112023 id706 - removido tipoOcorrencia 
            $idServico = $jsonEntrada['idServico'];
            $horasPrevisao  = isset($jsonEntrada['horasPrevisao'])  && $jsonEntrada['horasPrevisao'] !== "" && $jsonEntrada['horasPrevisao'] !== "null" ? "'". $jsonEntrada['horasPrevisao']."'"  : "null";
            $idAtendente = isset($jsonEntrada['idAtendente'])  && $jsonEntrada['idAtendente'] !== "" ?  $jsonEntrada['idAtendente']    : "null";
            $dataPrevisaoEntrega  = isset($jsonEntrada['dataPrevisaoEntrega'])  && $jsonEntrada['dataPrevisaoEntrega'] !== "" && $jsonEntrada['dataPrevisaoEntrega'] !== "null" ? "'". $jsonEntrada['dataPrevisaoEntrega']."'"  : "null";
            $dataPrevisaoInicio  = isset($jsonEntrada['dataPrevisaoInicio'])  && $jsonEntrada['dataPrevisaoInicio'] !== "" && $jsonEntrada['dataPrevisaoInicio'] !== "null" ? "'". $jsonEntrada['dataPrevisaoInicio']."'"  : "null";
            $tempoCobradoEntrada = isset($jsonEntrada["tempoCobrado"])  && $jsonEntrada["tempoCobrado"] !== "" && $jsonEntrada["tempoCobrado"] !== "null" ? "'". $jsonEntrada["tempoCobrado"]."'"  : "null";

            //Busca tempoCObrado de Demanda  
            $sql_consulta = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
            $buscar_consulta = mysqli_query($conexao, $sql_consulta);
            $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
            $idContrato = isset($row_consulta["idContrato"])  && $row_consulta["idContrato"] !== "" ?  $row_consulta["idContrato"]    : "null";
            $tempoCobradoAutal = $row_consulta["tempoCobrado"];
            $tempoCobradoAutal = "'". $tempoCobradoAutal . "'";

        $sql = "UPDATE demanda SET prioridade = $prioridade, tituloDemanda = $tituloDemanda, idServico = $idServico, idAtendente = $idAtendente,
        horasPrevisao = $horasPrevisao, idContrato = $idContrato, dataPrevisaoEntrega = $dataPrevisaoEntrega, dataPrevisaoInicio = $dataPrevisaoInicio ";

            if (($tempoCobradoEntrada != $tempoCobradoAutal) && ($tempoCobradoEntrada != "null")) {
                $tempoCobrado = $tempoCobradoEntrada;
                $tempoCobradoDigitado = '1';
            
            $sql = $sql . ",tempoCobrado = $tempoCobrado, tempoCobradoDigitado = $tempoCobradoDigitado ";
            }
    }

    $sql = $sql . ", dataAtualizacaoAtendente=CURRENT_TIMESTAMP()  WHERE idDemanda = $idDemanda";

    //echo 'SQL' . $sql;
  
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