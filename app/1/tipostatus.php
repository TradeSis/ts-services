<?php
//gabriel 06022023 16:52
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
/*
{
		"mudaStatusPara" : 1,
		"idTipoStatus" : null
}
*/

$conexao = conectaMysql();
$tipostatus = array();



$sql = "SELECT * FROM tipostatus ";
if (isset($jsonEntrada["idTipoStatus"])) {
  $sql = $sql . " where tipostatus.idTipoStatus = " . $jsonEntrada["idTipoStatus"];
} else {
  $where = " where ";
  if (isset($jsonEntrada["statusInicial"])) {
    $sql = $sql . $where . " tipostatus.statusInicial = " . $jsonEntrada["statusInicial"];
  }
}

//echo "-SQL->".json_encode($sql)."\n";
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($tipostatus, $row);
  $rows = $rows + 1;
}
//echo "-ARRAY->".json_encode($tipostatus)."\n";

if (isset($jsonEntrada["idTipoStatus"]) && $rows==1) {
  $tipostatus = $tipostatus[0];
}

$jsonSaida = $tipostatus;

//echo "-SAIDA->".json_encode($jsonSaida)."\n";


?>