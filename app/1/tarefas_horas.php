<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
$horas = array();
$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(horasCobrado))) AS horasCobrado, SEC_TO_TIME(SUM(TIME_TO_SEC(horasReal))) AS horasReal 
  FROM  (SELECT TIMEDIFF(tarefa.horaFinalCobrado, tarefa.horaInicioCobrado) AS horasCobrado, 
  TIMEDIFF(tarefa.horaFinalReal, tarefa.horaInicioReal) AS horasReal FROM tarefa";
if (isset($jsonEntrada["idDemanda"])) {
  $sql = $sql . " where tarefa.idDemanda = " . $jsonEntrada["idDemanda"] . " ) as subquery"; 
}
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($horas, $row);
  $rows = $rows + 1;
}
if (isset($jsonEntrada["idDemanda"]) && $rows==1) {
  $horas = $horas[0];
}
$jsonSaida = $horas;


?>