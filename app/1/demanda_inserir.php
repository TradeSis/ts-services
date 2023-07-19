<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
$posicao = null;
$statusDemanda = null;

if (isset($jsonEntrada['tituloDemanda'])) {
    $idCliente = $jsonEntrada['idCliente'];
    $idSolicitante = $jsonEntrada['idSolicitante'];
    $tituloDemanda = $jsonEntrada['tituloDemanda'];
    $descricao = $jsonEntrada['descricao'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];
    $idServico = $jsonEntrada['idServico'];

    //busca dados tipostatus    
        $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $posicao = $row["mudaPosicaoPara"];
        $statusDemanda = $row["mudaStatusPara"];

    $sql = "INSERT INTO demanda(prioridade, tituloDemanda, descricao, dataAbertura, idTipoStatus, idTipoOcorrencia, posicao, statusDemanda, idCliente, idSolicitante, idServico) VALUES (99, '$tituloDemanda','$descricao', CURRENT_TIMESTAMP(), $idTipoStatus, $idTipoOcorrencia, $posicao, $statusDemanda, $idCliente, $idSolicitante, $idServico)";

    if ($atualizar = mysqli_query($conexao, $sql)) {
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } else {
        
        $jsonSaida = array(
            "status" => 500,
            "retorno" => "erro no mysql"
        );
    }
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}
