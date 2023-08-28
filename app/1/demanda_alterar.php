<?php
// Lucas 10032023 - pequeno ajuste ao montar o slq, faltava uma virgula de pois de descricao='$descricao',
// gabriel 06032023 11:25 alteração de descricao demanda
// gabriel 02032023 12:13 alteração de titulo demanda
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$idEmpresa = null;
	if (isset($jsonEntrada["idEmpresa"])) {
    	$idEmpresa = $jsonEntrada["idEmpresa"];
	}
$conexao = conectaMysql($idEmpresa);


if (isset($jsonEntrada['idDemanda'])) {
    $idDemanda = $jsonEntrada['idDemanda'];
    $tituloDemanda = $jsonEntrada['tituloDemanda'];
    $descricao = $jsonEntrada['descricao'];
    $prioridade = $jsonEntrada['prioridade'];
    $idServico = $jsonEntrada['idServico'];
    $tamanho = isset($jsonEntrada['tamanho']) && $jsonEntrada['tamanho'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['tamanho']) . "'" : "NULL";
    $idAtendente = isset($jsonEntrada['idAtendente']) && $jsonEntrada['idAtendente'] !== "" ? $jsonEntrada['idAtendente'] : "NULL";
    $horasPrevisao = $jsonEntrada['horasPrevisao'];
    $idContrato = isset($jsonEntrada['idContrato']) && $jsonEntrada['idContrato'] !== "" ? $jsonEntrada['idContrato'] : "NULL";
    $idContratoTipo = $jsonEntrada['idContratoTipo'];

    $sql = "UPDATE demanda SET prioridade=$prioridade, tituloDemanda='$tituloDemanda', descricao='$descricao', idServico=$idServico, tamanho=$tamanho, idAtendente=$idAtendente, horasPrevisao='$horasPrevisao', idContrato=$idContrato, idContratoTipo=$idContratoTipo, dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda";
    //echo "-SQL->" . json_encode($sql) . "\n";
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