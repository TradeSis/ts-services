<?php
// Lucas 22032023 adicionado if de tituloOrcamento
// Lucas 21032023 ajustado estrutura dentro do else, adicionado $where;
// Lucas 20032023 adicionar if de idCliente
// Lucas 17022023 adicionado condição else para idOrcamentoStatus
// Lucas 07022023 criacao

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "orcamento";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "orcamento_" . date("dmY") . ".log", "a");
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

$orcamento = array();

$sql = "SELECT orcamento.*, cliente.*, orcamentostatus.* FROM orcamento				
        INNER JOIN cliente on cliente.idCliente = orcamento.idcliente 
        INNER JOIN orcamentostatus  on  orcamento.statusOrcamento = orcamentostatus.idOrcamentoStatus  ";
if (isset($jsonEntrada["idOrcamento"])) {
  $sql = $sql . " where orcamento.idOrcamento = " . $jsonEntrada["idOrcamento"];
} else {
  $where = " where ";

  if (isset($jsonEntrada["idCliente"])) {
    $sql = $sql . $where . " orcamento.idCliente = " . $jsonEntrada["idCliente"];
    $where = " and ";
  }

  if (isset($jsonEntrada["statusOrcamento"])) {
    $sql = $sql . $where . " orcamento.statusOrcamento = " . $jsonEntrada["statusOrcamento"];
    $where = " and ";
  } 

  if (isset($jsonEntrada["buscaOrcamento"])) {
    $sql = $sql . $where . " orcamento.idOrcamento= " . $jsonEntrada["buscaOrcamento"] . " or . orcamento.tituloOrcamento like " . "'%" . $jsonEntrada["buscaOrcamento"] . "%'";
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
  array_push($orcamento, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idOrcamento"]) && $rows == 1) {
  $orcamento = $orcamento[0];
}
$jsonSaida = $orcamento;

//echo "-SAIDA->".json_encode($jsonSaida)."\n";

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG