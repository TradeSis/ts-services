<?php
// Lucas 07022023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
$idEmpresa = $jsonEntrada["idEmpresa"];
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idContrato'])) {
        $idContrato = $jsonEntrada['idContrato'];
        $dataFechamento = $jsonEntrada['dataFechamento'];
        
	   
    $sql = "UPDATE `contrato` SET `dataFechamento`='$dataFechamento' WHERE contrato.idContrato = $idContrato ";
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