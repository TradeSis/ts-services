<?php
// Lucas 07022023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
if (isset($jsonEntrada['nomeContratoStatus'])) {
    $nomeContratoStatus = $jsonEntrada['nomeContratoStatus'];
    $mudaStatusPara = $jsonEntrada['mudaStatusPara'];
    $sql = "INSERT INTO contratostatus (nomeContratoStatus, mudaStatusPara) values ('$nomeContratoStatus', $mudaStatusPara)";
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