<?php
// helio 12072023 - ajustes de horas
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


/* LOG em arquivo
$arqlog = defineCaminhoLog()."/api/php_errors.log";
$arquivo = fopen($arqlog,"a");
fwrite($arquivo,"jsonEntrada->".json_encode($jsonEntrada)."\n");   
*/
$statusTarefa = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_RESPONDIDO,
);


$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);

if (isset($jsonEntrada['idTarefa'])) {
    $idTarefa = $jsonEntrada['idTarefa'];
    $idDemanda = $jsonEntrada['idDemanda'];
    $idDemandaSelect = $jsonEntrada['idDemandaSelect'];
    $tituloTarefa = $jsonEntrada['tituloTarefa'];
    $idAtendente = $jsonEntrada['idAtendente'];

    $idTipoOcorrencia = isset($jsonEntrada['idTipoOcorrencia']) && $jsonEntrada['idTipoOcorrencia'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['idTipoOcorrencia']) . "'" : "NULL";
    $tipoStatusDemanda = isset($jsonEntrada['tipoStatusDemanda']) && $jsonEntrada['tipoStatusDemanda'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['tipoStatusDemanda']) . "'" : "NULL";
    $dataReal = isset($jsonEntrada['dataReal']) && $jsonEntrada['dataReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataReal']) . "'" : "NULL";
    $horaInicioReal = isset($jsonEntrada['horaInicioReal']) && $jsonEntrada['horaInicioReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioReal']) . "'" : "NULL";
    $horaFinalReal = isset($jsonEntrada['horaFinalReal']) && $jsonEntrada['horaFinalReal'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalReal']) . "'" : "NULL";
    $horaCobrado = isset($jsonEntrada['horaCobrado']) && $jsonEntrada['horaCobrado'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaCobrado']) . "'" : "NULL";
    $Previsto = isset($jsonEntrada['Previsto']) && $jsonEntrada['Previsto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['Previsto']) . "'" : "NULL";
    $horaInicioPrevisto = isset($jsonEntrada['horaInicioPrevisto']) && $jsonEntrada['horaInicioPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaInicioPrevisto']) . "'" : "NULL";
    $horaFinalPrevisto = isset($jsonEntrada['horaFinalPrevisto']) && $jsonEntrada['horaFinalPrevisto'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['horaFinalPrevisto']) . "'" : "NULL";


    if ($idDemandaSelect !== null) {
        // busca dados idCliente/Demanda
        $sql2 = "SELECT * FROM demanda WHERE idDemanda = $idDemandaSelect";
        $buscar2 = mysqli_query($conexao, $sql2);
        $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
        $idCliente = $row["idCliente"];


        $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`=$horaCobrado,
    `dataReal`=$dataReal, `horaInicioReal`=$horaInicioReal, `horaFinalReal`=$horaFinalReal, `idDemanda`=$idDemandaSelect, `idCliente`=$idCliente,
    `Previsto`=$Previsto, `horaInicioPrevisto`=$horaInicioPrevisto, `horaFinalPrevisto`=$horaFinalPrevisto 
    WHERE `idTarefa` = $idTarefa";
    } else {
        $sql = "UPDATE `tarefa` SET `tituloTarefa`='$tituloTarefa', `idTipoOcorrencia`=$idTipoOcorrencia, `idAtendente`=$idAtendente, `horaCobrado`=$horaCobrado,
        `dataReal`=$dataReal, `horaInicioReal`=$horaInicioReal, `horaFinalReal`=$horaFinalReal,
        `Previsto`=$Previsto, `horaInicioPrevisto`=$horaInicioPrevisto, `horaFinalPrevisto`=$horaFinalPrevisto 
        WHERE `idTarefa` = $idTarefa";
    }
    $atualizar = mysqli_query($conexao, $sql);

    if (isset($jsonEntrada['idDemanda'])) {
        if (isset($jsonEntrada['Previsto'])) {
            if (in_array($tipoStatusDemanda, $statusTarefa)) {
                $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda, idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
                $atualizar3 = mysqli_query($conexao, $sql3);
            } else {
                $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
                $atualizar3 = mysqli_query($conexao, $sql3);
            }
        } else {
            $sql3 = "UPDATE demanda SET dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), idTipoOcorrencia=$idTipoOcorrencia WHERE idDemanda = $idDemanda";
        }
        $atualizar3 = mysqli_query($conexao, $sql3);
    }

    if ($atualizar) {
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