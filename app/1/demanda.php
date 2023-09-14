<?php
// Lucas 19052023 adicionado if para filtro de tamanho
// Lucas 22032023 adicionado if para filtro de tituloDemanda
// Lucas 21032023 ajustado estrutura dentro do else, para os novos filtros.
// Lucas 17022023 adicionado condição else para idTipoStatus
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG 
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "demanda_select";
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
$demanda = array();

$sql = "SELECT demanda.*, contratotipos.*, cliente.nomeCliente, tipoocorrencia.nomeTipoOcorrencia, tipostatus.nomeTipoStatus, contrato.tituloContrato, servicos.nomeServico, atendente.nomeUsuario AS nomeAtendente, solicitante.nomeUsuario AS nomeSolicitante FROM demanda
        LEFT JOIN cliente ON demanda.idCliente = cliente.idCliente
        LEFT JOIN usuario AS atendente ON demanda.idAtendente = atendente.idUsuario
        LEFT JOIN usuario AS solicitante ON demanda.idSolicitante = solicitante.idUsuario
        LEFT JOIN contrato ON demanda.idContrato = contrato.idContrato
        LEFT JOIN servicos ON demanda.idServico = servicos.idServico
        LEFT JOIN tipoocorrencia ON demanda.idTipoOcorrencia = tipoocorrencia.idTipoOcorrencia
        LEFT JOIN tipostatus ON demanda.idTipoStatus = tipostatus.idTipoStatus
        LEFT JOIN contratotipos  on  demanda.idContratoTipo = contratotipos.idContratoTipo ";
$where = " where ";
if (isset($jsonEntrada["idDemanda"]) && $jsonEntrada["idDemanda"] !== "") {
  $sql = $sql . $where . " demanda.idDemanda = " . $jsonEntrada["idDemanda"];
}

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

if (isset($jsonEntrada["buscaDemanda"])) {
  $sql = $sql . $where . " demanda.idDemanda= " . $jsonEntrada["buscaDemanda"] . " or . demanda.tituloDemanda like " . "'%" . $jsonEntrada["buscaDemanda"] . "%'";
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

if (isset($jsonEntrada["idContratoTipo"])) {
  $sql = $sql . $where . " contratotipos.idContratoTipo = " . "'" . $jsonEntrada["idContratoTipo"] . "'";
  $where = " and ";
}




$sql = $sql . " order by ordem, prioridade, idDemanda";
//echo "-SQL->".json_encode($sql)."\n";
$rows = 0;

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 3) {
    fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
  }
}
//LOG


//TRY-CATCH
try {

  $buscar = mysqli_query($conexao, $sql);
  if (!$buscar)
    throw new Exception(mysqli_error($conexao));

  while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
    array_push($demanda, $row);
    $rows = $rows + 1;
  }
  if (isset($jsonEntrada["idDemanda"]) && $rows == 1) {
    $demanda = $demanda[0];
  }
  $jsonSaida = $demanda;

} catch (Exception $e) {
  $jsonSaida = array(
    "status" => 500,
    "retorno" => $e->getMessage()
  );
  if ($LOG_NIVEL >= 1) {
    fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
  }

} finally {
  // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
}
//TRY-CATCH




//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 3) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG