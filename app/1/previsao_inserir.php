<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$statusTarefa = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_RESPONDIDO,
);

$conexao = conectaMysql();
if (isset($jsonEntrada['idDemanda'])) {
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $idCliente = $jsonEntrada['idCliente'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $idAtendente = $jsonEntrada['idAtendente'];
    $Previsto = $jsonEntrada['Previsto'];
    $horaInicioPrevisto = $jsonEntrada['horaInicioPrevisto'];
    $horaFinalPrevisto = $jsonEntrada['horaFinalPrevisto'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $tipoStatusDemanda = $jsonEntrada['tipoStatusDemanda'];
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];

    $sql = "INSERT INTO tarefa(tituloTarefa, idCliente, idDemanda, idAtendente, Previsto, horaInicioPrevisto, horaFinalPrevisto, idTipoOcorrencia) VALUES ('$tituloTarefa', $idCliente, $idDemanda, $idAtendente, '$Previsto', '$horaInicioPrevisto', '$horaFinalPrevisto', $idTipoOcorrencia)";
    $atualizar = mysqli_query($conexao, $sql);

    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];

    if (in_array($tipoStatusDemanda, $statusTarefa)) {
        $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        $atualizar3 = mysqli_query($conexao, $sql3);
    } else {
        $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        $atualizar3 = mysqli_query($conexao, $sql3);
    }
    if ($atualizar && $atualizar3) {
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
        "retorno" => "Faltaram parâmetros"
    );
}