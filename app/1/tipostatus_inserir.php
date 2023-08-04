<?php
//gabriel 06022023 16:52
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
if (isset($jsonEntrada['nomeTipoStatus'])) {
    $nomeTipoStatus = $jsonEntrada['nomeTipoStatus'];
    $mudaPosicaoPara = $jsonEntrada['mudaPosicaoPara'];
    $mudaStatusPara = $jsonEntrada['mudaStatusPara'];
    $sql = "INSERT INTO tipostatus (nomeTipoStatus, mudaPosicaoPara, mudaStatusPara) values ('$nomeTipoStatus', $mudaPosicaoPara, $mudaStatusPara)";
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