<?php

//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$idEmpresa = null;
	if (isset($jsonEntrada["idEmpresa"])) {
    	$idEmpresa = $jsonEntrada["idEmpresa"];
	}
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idContratoTipo'])) {
    $idContratoTipo = $jsonEntrada['idContratoTipo'];
    $nomeContrato = $jsonEntrada['nomeContrato'];
    $nomeDemanda = $jsonEntrada['nomeDemanda'];

    $sql = "UPDATE contratotipos SET idContratoTipo='$idContratoTipo',nomeContrato='$nomeContrato',nomeDemanda='$nomeDemanda' WHERE idContratoTipo = '$idContratoTipo'";

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

?>