<?php
// Gabriel 26022024 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "orcamento_alterar";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "orcamento_" . date("dmY") . ".log", "a");
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
if (isset($jsonEntrada['idOrcamento'])) {
    $idOrcamento = $jsonEntrada['idOrcamento'];
    $tituloOrcamento = isset($jsonEntrada['tituloOrcamento']) && $jsonEntrada['tituloOrcamento'] !== "" ? "'" . $jsonEntrada['tituloOrcamento'] . "'" : "NULL";
    $descricao = isset($jsonEntrada['descricao']) && $jsonEntrada['descricao'] !== "" ? "'" . $jsonEntrada['descricao'] . "'" : "NULL";
    $idCliente = isset($jsonEntrada['idCliente']) && $jsonEntrada['idCliente'] !== "" ? "'" . $jsonEntrada['idCliente'] . "'" : "NULL";
    $dataAprovacao = isset($jsonEntrada['dataAprovacao']) && $jsonEntrada['dataAprovacao'] !== "" && $jsonEntrada['dataAprovacao'] !== "NULL" ? "'" . $jsonEntrada['dataAprovacao'] . "'" : "NULL";
    $horas = isset($jsonEntrada['horas']) && $jsonEntrada['horas'] !== "" ? "'" . $jsonEntrada['horas'] . "'" : "NULL";
    $valorHora = isset($jsonEntrada['valorHora']) && $jsonEntrada['valorHora'] !== "" ? "'" . $jsonEntrada['valorHora'] . "'" : "NULL";
    $valorOrcamento = isset($jsonEntrada['valorOrcamento']) && $jsonEntrada['valorOrcamento'] !== "" ? "'" . $jsonEntrada['valorOrcamento'] . "'" : "NULL";
    $statusOrcamento = isset($jsonEntrada['statusOrcamento']) && $jsonEntrada['statusOrcamento'] !== "" ? "'" . $jsonEntrada['statusOrcamento'] . "'" : "NULL";


    $sql = "UPDATE orcamento SET tituloOrcamento=$tituloOrcamento, descricao=$descricao, idCliente=$idCliente, dataAprovacao=$dataAprovacao,
                horas=$horas, valorHora=$valorHora, valorOrcamento=$valorOrcamento, statusOrcamento=$statusOrcamento WHERE idOrcamento = $idOrcamento";




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
