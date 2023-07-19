<?php
//gabriel 06022023 16:52
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
$tipoocorrencia = array();

$sql = "SELECT * FROM tipoocorrencia ";
if (isset($jsonEntrada["idTipoOcorrencia"])) {
  $sql = $sql . " where tipoocorrencia.idTipoOcorrencia = " . $jsonEntrada["idTipoOcorrencia"];
} else {
if (isset($jsonEntrada["ocorrenciaInicial"])) {
  $sql = $sql . " where tipoocorrencia.ocorrenciaInicial = " . $jsonEntrada["ocorrenciaInicial"];
}}
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($tipoocorrencia, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idTipoOcorrencia"]) && $rows==1) {
  $tipoocorrencia = $tipoocorrencia[0];
}
if (isset($jsonEntrada["ocorrenciaInicial"]) && $rows==1) {
  $tipoocorrencia = $tipoocorrencia[0];
}
$jsonSaida = $tipoocorrencia;

/** VARIAVEL A MAO 
$retorno = '[{"idCliente":"3","nomeCliente":"Loja Aduana"},{"idCliente":"24","nomeCliente":"Lebes"}]';
$jsonSaida =  json_decode($retorno, TRUE);
**/


?>