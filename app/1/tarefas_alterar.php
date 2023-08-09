<?php
// helio 12072023 - ajustes de horas
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$conexao = conectaMysql();

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $idDemandaSelect = $jsonEntrada['idDemandaSelect'];
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
    if($horaCobrado==''){$horaCobrado=null;}
    if($dataReal==''){$dataReal=null;}
    if($horaInicioReal==''){$horaInicioReal=null;}
    if($horaFinalReal==''){$horaFinalReal=null;}
    if($Previsto==''){$Previsto=null;}
    if($horaInicioPrevisto==''){$horaInicioPrevisto=null;}
    if($horaFinalPrevisto==''){$horaFinalPrevisto=null;} 

    echo json_encode($jsonEntrada);
    // busca dados idCliente
    if ($idDemandaSelect!== null) {    
    $sql2 = "SELECT * FROM demanda WHERE idDemanda = $idDemandaSelect"; 
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $idCliente = $row["idCliente"];
    

    $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`='$horaCobrado',
    `dataReal`='$dataReal', `horaInicioReal`='$horaInicioReal', `horaFinalReal`='$horaFinalReal', `idDemanda`=$idDemandaSelect, `idCliente`=$idCliente,
    `Previsto`='$Previsto', `horaInicioPrevisto`='$horaInicioPrevisto', `horaFinalPrevisto`='$horaFinalPrevisto' 
    WHERE `idTarefa` = $idTarefa"; 
    } else {
        $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`='$horaCobrado',
        `dataReal`='$dataReal', `horaInicioReal`='$horaInicioReal', `horaFinalReal`='$horaFinalReal',
        `Previsto`='$Previsto', `horaInicioPrevisto`='$horaInicioPrevisto', `horaFinalPrevisto`='$horaFinalPrevisto' 
        WHERE `idTarefa` = $idTarefa"; 
    }
    
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
