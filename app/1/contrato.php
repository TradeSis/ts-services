<?php
// Lucas 22032023 adicionado if de tituloContrato
// Lucas 21032023 ajustado estrutura dentro do else, adicionado $where;
// Lucas 20032023 adicionar if de idCliente
// Lucas 17022023 adicionado condição else para idContratoStatus
// Lucas 07022023 criacao

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "contrato";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "contrato_" . date("dmY") . ".log", "a");
    }
  }
}
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL == 1) {
    fwrite($arquivo, $identificacao . "\n");
  }
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
  }
}
//LOG

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
  $idEmpresa = $jsonEntrada["idEmpresa"];
}

$conexao = conectaMysql($idEmpresa);

$contrato = array();

$sql = "SELECT contrato.*, cliente.*, contratostatus.*, contratotipos.* FROM contrato				
        LEFT JOIN cliente on cliente.idCliente = contrato.idcliente 
        LEFT JOIN contratostatus  on  contrato.idContratoStatus = contratostatus.idContratoStatus
        LEFT JOIN contratotipos  on  contrato.idContratoTipo = contratotipos.idContratoTipo  ";
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
    $sql = $sql . $where . " contrato.statusContrato = " . $jsonEntrada["statusContrato"];
    $where = " and ";
  }

  if (isset($jsonEntrada["buscaContrato"])) {
    $sql = $sql . $where . " contrato.idContrato= " . $jsonEntrada["buscaContrato"] . " or . contrato.tituloContrato like " . "'%" . $jsonEntrada["buscaContrato"] . "%'";
    $where = " and ";
  }

  if (isset($jsonEntrada["idContratoTipo"])) {
    $sql = $sql . $where . " contratotipos.idContratoTipo = " . "'" . $jsonEntrada["idContratoTipo"] . "'";
    $where = " and ";
  }
}


//echo "-SQL->".$sql."\n"; 
//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 3) {
    fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
  }
}
//LOG

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

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG