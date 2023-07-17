<?php
// Lucas 19052023 adicionado if para filtro de tamanho
// Lucas 22032023 adicionado if para filtro de tituloDemanda
// Lucas 21032023 ajustado estrutura dentro do else, para os novos filtros.
// Lucas 17022023 adicionado condição else para idTipoStatus
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
$demanda = array();

$sql = "SELECT demanda.*, cliente.nomeCliente, tipoocorrencia.nomeTipoOcorrencia, tipostatus.nomeTipoStatus, contrato.tituloContrato, servicos.nomeServico, atendente.nomeUsuario AS nomeAtendente, solicitante.nomeUsuario AS nomeSolicitante FROM demanda
        LEFT JOIN cliente ON demanda.idCliente = cliente.idCliente
        LEFT JOIN usuario AS atendente ON demanda.idAtendente = atendente.idUsuario
        LEFT JOIN usuario AS solicitante ON demanda.idSolicitante = solicitante.idUsuario
        LEFT JOIN contrato ON demanda.idContrato = contrato.idContrato
        LEFT JOIN servicos ON demanda.idServico = servicos.idServico
        LEFT JOIN tipoocorrencia ON demanda.idTipoOcorrencia = tipoocorrencia.idTipoOcorrencia
        LEFT JOIN tipostatus ON demanda.idTipoStatus = tipostatus.idTipoStatus";
if (isset($jsonEntrada["idDemanda"])) {
  $sql = $sql . " where demanda.idDemanda = " . $jsonEntrada["idDemanda"];
} else {
  $where = " where ";

  if (isset($jsonEntrada["idCliente"])) {
    $sql = $sql . $where . " demanda.idCliente = " . $jsonEntrada["idCliente"];
    $where = " and ";
  }

  if (isset($jsonEntrada["idSolicitante"])) {
    $sql = $sql . $where . " demanda.idSolicitante = " . $jsonEntrada["idSolicitante"];
    $where = " and ";
  }

  if (isset($jsonEntrada["idTipoStatus"])) {
    $sql = $sql . $where . " demanda.idTipoStatus = " . $jsonEntrada["idTipoStatus"];
    $where = " and ";
  }

  if (isset($jsonEntrada["idTipoOcorrencia"])) {
    $sql = $sql . $where . " demanda.idTipoOcorrencia = " . $jsonEntrada["idTipoOcorrencia"];
    $where = " and ";
  }

  if (isset($jsonEntrada["idAtendente"])) {
    $sql = $sql . $where . " demanda.idAtendente = " . $jsonEntrada["idAtendente"];
    $where = " and ";
  }

  if (isset($jsonEntrada["statusDemanda"])) {
    $sql = $sql . $where . " demanda.statusDemanda = " . $jsonEntrada["statusDemanda"];
    $where = " and ";
  }

  if (isset($jsonEntrada["tituloDemanda"])) {
    $sql = $sql . $where . " demanda.tituloDemanda like " . "'%" . $jsonEntrada["tituloDemanda"] . "%'";
    $where = " and ";
  }

  if (isset($jsonEntrada["tamanho"])) {
    $sql = $sql . $where . " demanda.tamanho = " . "'" . $jsonEntrada["tamanho"] . "'";
    $where = " and ";
  }

  if (isset($jsonEntrada["idContrato"])) {
    $sql = $sql . $where . " demanda.idContrato = " . "'" . $jsonEntrada["idContrato"] . "'";
    $where = " and ";
  }



}
//echo "-SQL->".$sql."\n";

$sql = $sql . " order by ordem, prioridade, idDemanda";
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($demanda, $row);
  $rows = $rows + 1;
}
if (isset($jsonEntrada["idDemanda"]) && $rows == 1) {
  $demanda = $demanda[0];
}
$jsonSaida = $demanda;