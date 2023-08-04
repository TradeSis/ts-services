<?php
//gabriel 06022023 16:52
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
if (isset($jsonEntrada['idTipoStatus'])) {
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $nomeTipoStatus = $jsonEntrada['nomeTipoStatus'];
    $mudaPosicaoPara = $jsonEntrada['mudaPosicaoPara'];
    $mudaStatusPara = $jsonEntrada['mudaStatusPara'];
    $sql = "UPDATE tipostatus SET nomeTipoStatus='$nomeTipoStatus', mudaPosicaoPara=$mudaPosicaoPara, mudaStatusPara=$mudaStatusPara WHERE idTipoStatus = $idTipoStatus";
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