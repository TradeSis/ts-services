<?php
// Lucas 22032023 adicionado if de tituloContrato
// Lucas 21032023 ajustado estrutura dentro do else, adicionado $where;
// Lucas 20032023 adicionar if de idCliente
// Lucas 17022023 adicionado condição else para idContratoStatus
// Lucas 07022023 criacao

$conexao = conectaMysql();
$contrato = array();

$sql = "SELECT contrato.*, cliente.*, contratostatus.* FROM contrato				
        INNER JOIN cliente on cliente.idCliente = contrato.idcliente 
        INNER JOIN contratostatus  on  contrato.idContratoStatus = contratostatus.idContratoStatus  ";
if (isset($jsonEntrada["idContrato"])) {
  $sql = $sql . " where contrato.idContrato = " . $jsonEntrada["idContrato"];
} else {
  $where = " where ";

  if (isset($jsonEntrada["idCliente"])) {
    $sql = $sql . $where . " contrato.idCliente = " . $jsonEntrada["idCliente"];
    $where = " and ";
  }

  if (isset($jsonEntrada["idContratoStatus"])) {
    $sql = $sql . $where . " contrato.idContratoStatus = " . $jsonEntrada["idContratoStatus"];
    $where = " and ";
  }

  if (isset($jsonEntrada["statusContrato"])) {
    $sql = $sql . $where . " contrato.statusContrato = " . $jsonEntrada["statusContrato"];;
    $where = " and ";
  }

  if (isset($jsonEntrada["tituloContrato"])) {
    $sql = $sql . $where . " contrato.tituloContrato like " . "'%" . $jsonEntrada["tituloContrato"] . "%'";
    $where = " and ";
  }

}


//echo "-SQL->".$sql."\n";

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($contrato, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idContrato"]) && $rows == 1) {
  $contrato = $contrato[0];
}
$jsonSaida = $contrato;

//echo "-SAIDA->".json_encode($jsonSaida)."\n";
