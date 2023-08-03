<?php
// helio 12072023 - ajustes de horas
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$conexao = conectaMysql();

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $idTipoOcorrencia = $jsonEntrada['idTipoOcorrencia'];
    $idAtendente = $jsonEntrada['idAtendente'];
    $horaCobrado = $jsonEntrada['horaCobrado'];
    $dataReal = $jsonEntrada['dataReal'];
    $horaInicioReal = $jsonEntrada['horaInicioReal'];
    $horaFinalReal = $jsonEntrada['horaFinalReal'];
    $Previsto = $jsonEntrada['Previsto'];
    $horaInicioPrevisto = $jsonEntrada['horaInicioPrevisto'];
    $horaFinalPrevisto = $jsonEntrada['horaFinalPrevisto'];
  
    /* TESTE ZERADO */
    if($horaCobrado==''){$horaCobrado='0000-00-00';}
    if($dataReal==''){$dataReal='0000-00-00';}
    if($horaInicioReal==''){$horaInicioReal='00:00';}
    if($horaFinalReal==''){$horaFinalReal='00:00';}
    if($Previsto==''){$Previsto='0000-00-00';}
    if($horaInicioPrevisto==''){$horaInicioPrevisto='00:00';}
    if($horaFinalPrevisto==''){$horaFinalPrevisto='00:00';}


    $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`='$horaCobrado',
    `dataReal`='$dataReal', `horaInicioReal`='$horaInicioReal', `horaFinalReal`='$horaFinalReal', 
    `Previsto`='$Previsto', `horaInicioPrevisto`='$horaInicioPrevisto', `horaFinalPrevisto`='$horaFinalPrevisto' 
    WHERE `idTarefa` = $idTarefa";
    $atualizar = mysqli_query($conexao, $sql);

    $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
    $atualizar3 = mysqli_query($conexao, $sql3);

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
