<?php
// Lucas 07022023 criacao

$conexao = conectaMysql();
$contratostatus = array();


$sql = "SELECT * FROM contratostatus ";
if (isset($jsonEntrada["idContratoStatus"])) {
  $sql = $sql . " where contratostatus.idContratoStatus = " . $jsonEntrada["idContratoStatus"];
}
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($contratostatus, $row);
  $rows = $rows + 1;

 
}

if (isset($jsonEntrada["idContratoStatus"]) && $rows==1) {
  $contratostatus = $contratostatus[0];
}
$jsonSaida = $contratostatus;

//echo "-SAIDA->".json_encode($jsonSaida)."\n";


?>