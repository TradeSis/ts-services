<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
if (isset($jsonEntrada['tituloTarefa'])) {
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $idCliente = $jsonEntrada['idCliente'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $idAtendente = $jsonEntrada['idAtendente'];
    $dataCobrado = $jsonEntrada['dataCobrado'];
    $horaInicioReal = $jsonEntrada['horaInicioReal'];
    $horaFinalReal = $jsonEntrada['horaFinalReal'];
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];

    $sql = "INSERT INTO tarefa(tituloTarefa, idCliente, idDemanda, idAtendente, `dataCobrado`, horaInicioReal, horaFinalReal, idTipoOcorrencia) VALUES ('$tituloTarefa', $idCliente, $idDemanda, $idAtendente, $dataCobrado, '$horaInicioReal', '$horaFinalReal', $idTipoOcorrencia)";

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