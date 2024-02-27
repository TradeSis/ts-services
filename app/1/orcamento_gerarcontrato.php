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

    $sql_consulta = "SELECT * FROM orcamento WHERE idOrcamento = $idOrcamento";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    $tituloOrcamento = isset($row_consulta['tituloOrcamento']) && $row_consulta['tituloOrcamento'] !== "" ? "'" . $row_consulta['tituloOrcamento'] . "'" : "NULL";
    $descricao = isset($row_consulta['descricao']) && $row_consulta['descricao'] !== "" ? "'" . $row_consulta['descricao'] . "'" : "NULL";
    $dataAbertura = isset($row_consulta['dataAbertura']) && $row_consulta['dataAbertura'] !== "" && $row_consulta['dataAbertura'] !== "NULL" ? "'" . $row_consulta['dataAbertura'] . "'" : "NULL";
    $idCliente = isset($row_consulta['idCliente']) && $row_consulta['idCliente'] !== "" ? "'" . $row_consulta['idCliente'] . "'" : "NULL";
    $dataAprovacao = isset($row_consulta['dataAprovacao']) && $row_consulta['dataAprovacao'] !== "" && $row_consulta['dataAprovacao'] !== "NULL" ? "'" . $row_consulta['dataAprovacao'] . "'" : "NULL";
    $horas = isset($row_consulta['horas']) && $row_consulta['horas'] !== "" ? "'" . $row_consulta['horas'] . "'" : "NULL";
    $valorHora = isset($row_consulta['valorHora']) && $row_consulta['valorHora'] !== "" ? "'" . $row_consulta['valorHora'] . "'" : "NULL";
    $valorOrcamento = isset($row_consulta['valorOrcamento']) && $row_consulta['valorOrcamento'] !== "" ? "'" . $row_consulta['valorOrcamento'] . "'" : "NULL";
    $statusOrcamento = isset($row_consulta['statusOrcamento']) && $row_consulta['statusOrcamento'] !== "" ? "'" . $row_consulta['statusOrcamento'] . "'" : "NULL";

    $idContratoStatus = 1; //Orçamento
    $statusContrato = "NULL";
    $idContratoTipo = "'" . $jsonEntrada['idContratoTipo'] . "'";

    $sql = "INSERT INTO contrato (tituloContrato, descricao, dataAbertura, idContratoStatus, idCliente, statusContrato, horas, valorHora, valorContrato, idContratoTipo) 
                            values ($tituloOrcamento, $descricao, $dataAbertura, $idContratoStatus, $idCliente, $statusContrato, $horas, $valorHora, $valorOrcamento, $idContratoTipo)";

    $atualizar = mysqli_query($conexao, $sql);

    $idContratoInserido = mysqli_insert_id($conexao);

    $sql_consulta2 = "SELECT * FROM orcamentoitens WHERE idOrcamento = $idOrcamento";
    $buscar_consulta2 = mysqli_query($conexao, $sql_consulta2);
    while ($row_consulta2 = mysqli_fetch_array($buscar_consulta2, MYSQLI_ASSOC)) {
        $idItemOrcamento = isset($row_consulta2['idItemOrcamento']) && $row_consulta2['idItemOrcamento'] !== "" ? $row_consulta2['idItemOrcamento'] : "null";
        $tituloItemOrcamento = isset($row_consulta2['tituloItemOrcamento']) && $row_consulta2['tituloItemOrcamento'] !== "" ? $row_consulta2['tituloItemOrcamento'] : "null";
        $horas = isset($row_consulta2['horas']) && $row_consulta2['horas'] !== "" ? $row_consulta2['horas'] : "null";

        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idCliente' => $row_consulta['idCliente'],
            'idSolicitante' => $jsonEntrada['idSolicitante'],
            'tituloDemanda' => $row_consulta2['tituloItemOrcamento'],
            'idContrato' => $idContratoInserido,
            'idContratoTipo' => $jsonEntrada['idContratoTipo'],
            'horasPrevisao' => $row_consulta2['horas'],
            'tempoCobrado' => $row_consulta2['horas'],
        );  
        echo json_encode($apiEntrada);
        $demanda = chamaAPI(null, '/services/demanda', json_encode($apiEntrada), 'PUT');

    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    if ($atualizar) {
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } else {
        $jsonSaida = array(
            "status" => 501,
            "retorno" => "erro no mysql"
        );
    }

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
