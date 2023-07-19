<?php
//gabriel 28022023 16:33 alterado para LEFT JOIN no usuario
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
$tarefa = array();
$sql = "SELECT tarefa.*, usuario.nomeUsuario, cliente.nomeCliente, demanda.tituloDemanda, tipoocorrencia.nomeTipoOcorrencia,
        TIMEDIFF(tarefa.horaFinalCobrado, tarefa.horaInicioCobrado) AS horasCobrado, 
        TIMEDIFF(tarefa.horaFinalReal, tarefa.horaInicioReal) AS horasReal, 
        TIMEDIFF(tarefa.horaFinalPrevisto, tarefa.horaInicioPrevisto) AS horasPrevisto FROM tarefa
        LEFT JOIN usuario ON tarefa.idAtendente = usuario.idUsuario 
        LEFT JOIN demanda ON tarefa.idDemanda = demanda.idDemanda 
        LEFT JOIN tipoocorrencia ON tarefa.idTipoOcorrencia = tipoocorrencia.idTipoOcorrencia
        LEFT JOIN cliente ON tarefa.idCliente = cliente.idCliente";
if (isset($jsonEntrada["idDemanda"])) {
  $sql = $sql . " where tarefa.idDemanda = " . $jsonEntrada["idDemanda"];
}
if (isset($jsonEntrada["idTarefa"])) {
  $sql = $sql . " and tarefa.idTarefa = " . $jsonEntrada["idTarefa"];
}
//echo "-SQL->".json_encode($sql)."\n";
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($tarefa, $row);
  $rows = $rows + 1;
}
if (isset($jsonEntrada["idTarefa"]) && $rows == 1) {
  $tarefa = $tarefa[0];
}
$jsonSaida = $tarefa;


?>