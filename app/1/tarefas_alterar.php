<?php
// helio 12072023 - ajustes de horas
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

/* LOG em arquivo
$arqlog = defineCaminhoLog()."/api/php_errors.log";
$arquivo = fopen($arqlog,"a");
fwrite($arquivo,"jsonEntrada->".json_encode($jsonEntrada)."\n");   
*/

$conexao = conectaMysql();

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $dataCobrado = $jsonEntrada['dataCobrado'];
    $horaInicioCobrado = $jsonEntrada['horaInicioCobrado'];
    $horaFinalCobrado = $jsonEntrada['horaFinalCobrado'];
  
    /* TESTE ZERADO */
    if($dataCobrado==''){$dataCobrado='0000-00-00';}
    if($horaInicioCobrado==''){$horaInicioCobrado='00:00';}
    if($horaFinalCobrado==''){$horaFinalCobrado='00:00';}

    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];

    $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa',`dataCobrado`='$dataCobrado', `horaInicioCobrado`='$horaInicioCobrado', `horaFinalCobrado`='$horaFinalCobrado', `idTipoOcorrencia`=$idTipoOcorrencia WHERE `idTarefa` = $idTarefa";

    if (mysqli_query($conexao, $sql)) {
        $sql2 = "UPDATE `demanda` SET `idTipoOcorrencia`=$idTipoOcorrencia WHERE `idDemanda` = $idDemanda";
        if (mysqli_query($conexao, $sql2)) {
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
            "status" => 500,
            "retorno" => "erro no mysql"
        );
    }
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );

    fclose($arquivo);

}
