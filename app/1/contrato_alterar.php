<?php
// Lucas 20022023 alterado if para resultar no $valorHora e adicionado o else para $valorContrato;
// Lucas 28022023 - condição para verificar a variavel valorContrato
// Lucas 07022023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "contrato_alterar";
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
if (isset($jsonEntrada['tituloContrato'])) {
    $idContrato = $jsonEntrada['idContrato'];
    $tituloContrato = $jsonEntrada['tituloContrato'];
    $descricao = $jsonEntrada['descricao'];
    $idContratoStatus = $jsonEntrada['idContratoStatus'];
    $dataPrevisao = $jsonEntrada['dataPrevisao'];
    $dataEntrega = $jsonEntrada['dataEntrega'];
    $horas = $jsonEntrada['horas'];
    $valorHora = $jsonEntrada['valorHora'];
    $idContratoTipo = $jsonEntrada['idContratoTipo'];

    $valorContrato = $jsonEntrada['valorContrato'];

    if (($horas == 0) && ($valorHora == 0.00)) {
        $valorContrato = 0;
    } else {
        if (($horas !== "") && ($valorContrato !== "")) {
            $valorHora = $valorContrato / $horas;
        } else {
            if (($horas !== "") && ($valorHora !== "")) {
                $valorContrato = $horas * $valorHora;
            }
        }
    }

    $dataPrevisao = isset($jsonEntrada['dataPrevisao']) && $jsonEntrada['dataPrevisao'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataPrevisao']) . "'" : "0000-00-00";
    $dataEntrega = isset($jsonEntrada['dataEntrega']) && $jsonEntrada['dataEntrega'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataEntrega']) . "'" : "0000-00-00";

    //busca dados tipostatus    
    $sql2 = "SELECT * FROM contratostatus WHERE idContratoStatus = $idContratoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $statusContrato = $row["mudaStatusPara"];

    $sql = "UPDATE `contrato` SET `tituloContrato`='$tituloContrato',`descricao`='$descricao',`idContratoStatus`='$idContratoStatus' ,`valorContrato`='$valorContrato',    `dataPrevisao`= $dataPrevisao,`dataEntrega`= $dataEntrega ,`statusContrato`='$statusContrato',`horas`= $horas,`valorHora`=$valorHora,`idContratoTipo`='$idContratoTipo', dataAtualizacao=CURRENT_TIMESTAMP () WHERE contrato.idContrato = $idContrato ";
    //echo "-SQL->".json_encode($sql)."\n";
    
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