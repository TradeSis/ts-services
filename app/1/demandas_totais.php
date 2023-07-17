<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
$card = array();


$sql = "SELECT
        SUM(CASE WHEN demanda.statusDemanda = 1 THEN 1 ELSE 0 END) AS totalAbertos,
        SUM(CASE WHEN demanda.statusDemanda = 0 THEN 1 ELSE 0 END) AS totalFechados,
        SUM(CASE WHEN demanda.statusDemanda = 1 AND demanda.idTipoStatus = 7 THEN 1 ELSE 0 END) AS totalAguardando,
        COUNT(demanda.idDemanda) AS totalDemandas
        FROM demanda";
//echo "-SQL->" . json_encode($sql) . "\n";
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($card, $row);
  $rows = $rows + 1;
}

$jsonSaida = $card[0];
?>