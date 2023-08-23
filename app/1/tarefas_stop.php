<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
$ROOT = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$ROOTex = explode("/", $ROOT);
$ROOTex = array_values(array_filter($ROOTex)); 

define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' . $ROOTex[0]);

require_once ROOT . '/config.php';

date_default_timezone_set('America/Sao_Paulo');
$conexao = conectaMysql();

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $horaFinalReal = date('H:i:00');
    $idDemanda = $jsonEntrada['idDemanda'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $tipoStatusDemanda = $jsonEntrada['tipoStatusDemanda'];


    $sql = "UPDATE `tarefa` SET `horaFinalReal`='$horaFinalReal' WHERE idTarefa = $idTarefa";
    $atualizar = mysqli_query($conexao, $sql);

    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];


    if ($tipoStatusDemanda == TIPOSTATUS_FAZENDO) {
        $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        $atualizar3 = mysqli_query($conexao, $sql3);
    } else {
        $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda";
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