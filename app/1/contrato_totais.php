<?php
// Lucas 07022023 criacao

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "contrato_totais";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "services_" . date("dmY") . ".log", "a");
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
$totais = array();

$sql = "
SELECT  contrato.idContratoStatus, 
        contratostatus.nomeContratoStatus, 
        count(*) as 'qtdContratos' , 
        sum(contrato.valorContrato) as 'valorContratos'
FROM contrato , contratostatus
where 
    contrato.idContratoStatus = contratostatus.idContratoStatus
group BY 
    contrato.idContratoStatus, contratostatus.nomeContratoStatus
";
/*if (isset($jsonEntrada["idContrato"])) {
  $sql = $sql . " where contrato.idContrato = " . $jsonEntrada["idContrato"];
}*/

//echo "-SQL->".$sql."\n";

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 3) {
    fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
  }
}
//LOG

$total = array();
$valorContratos = 0;
$qtdContratos = 0;

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  $valorContratos = $valorContratos + $row["valorContratos"];
  $qtdContratos = $qtdContratos + $row["qtdContratos"];
  array_push($totais, $row);
  $rows = $rows + 1;
}
$total = array(
  "idContratoStatus" => "0",
  "nomeContratoStatus" => "Total",
  "qtdContratos" => $qtdContratos,
  "valorContratos" => $valorContratos
);

array_push($totais, $total);
/*
if (isset($jsonEntrada["idContrato"]) && $rows==1) {
  $contrato = $contrato[0];
}
*/
$jsonSaida = $totais;

//echo "-SAIDA->".json_encode($jsonSaida)."\n";

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG
