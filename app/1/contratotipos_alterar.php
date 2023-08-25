<?php

//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$idEmpresa = null;
	if (isset($jsonEntrada["idEmpresa"])) {
    	$idEmpresa = $jsonEntrada["idEmpresa"];
	}
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idContratoTipo'])) {
    $idContratoTipo = $jsonEntrada['idContratoTipo'];
    $nomeContratoTipo = $jsonEntrada['nomeContratoTipo'];

    $sql = "UPDATE contratotipos SET nomeContratoTipo='$nomeContratoTipo' WHERE idContratoTipo = $idContratoTipo";
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