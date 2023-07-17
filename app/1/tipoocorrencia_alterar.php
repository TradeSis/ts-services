<?php
//gabriel 06022023 16:52
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
if (isset($jsonEntrada['idTipoOcorrencia'])) {
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];
    $nomeTipoOcorrencia = $jsonEntrada['nomeTipoOcorrencia'];
    $sql = "UPDATE tipoocorrencia SET nomeTipoOcorrencia='$nomeTipoOcorrencia' WHERE idTipoOcorrencia = $idTipoOcorrencia";
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