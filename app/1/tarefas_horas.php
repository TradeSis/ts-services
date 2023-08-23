<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);

$tarefa = array();
$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(subquery.horaCobrado))) AS totalHoraCobrado, SEC_TO_TIME(SUM(TIME_TO_SEC(subquery.horasReal))) AS totalHorasReal
        FROM (SELECT TIMEDIFF(tarefa.horaFinalReal, tarefa.horaInicioReal) AS horasReal, tarefa.horaCobrado FROM tarefa";

if (isset($jsonEntrada["idDemanda"])) {
  $sql = $sql . " where tarefa.idDemanda = " . $jsonEntrada["idDemanda"] . ") AS subquery";
}
//echo "-SQL->".json_encode($sql)."\n";
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($tarefa, $row);
  $rows = $rows + 1;
}
if (isset($jsonEntrada["idDemanda"]) && $rows == 1) {
  $tarefa = $tarefa[0];
}
$jsonSaida = $tarefa;


?>