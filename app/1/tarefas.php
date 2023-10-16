<?php
//gabriel 28022023 16:33 alterado para LEFT JOIN no usuario
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


//LOG 
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "tarefas_select";
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
$tarefa = array();
$sql = "SELECT tarefa.*, usuario.nomeUsuario, cliente.nomeCliente, demanda.tituloDemanda, demanda.idTipoStatus, tipoocorrencia.nomeTipoOcorrencia,
        TIMEDIFF(tarefa.horaFinalReal, tarefa.horaInicioReal) AS horasReal, 
        TIMEDIFF(tarefa.horaFinalPrevisto, tarefa.horaInicioPrevisto) AS horasPrevisto FROM tarefa
        LEFT JOIN usuario ON tarefa.idAtendente = usuario.idUsuario 
        LEFT JOIN demanda ON tarefa.idDemanda = demanda.idDemanda 
        LEFT JOIN tipoocorrencia ON tarefa.idTipoOcorrencia = tipoocorrencia.idTipoOcorrencia
        LEFT JOIN cliente ON tarefa.idCliente = cliente.idCliente";
$where = " where ";
if (isset($jsonEntrada["idTarefa"])) {
  $sql = $sql . $where . " tarefa.idTarefa = " . $jsonEntrada["idTarefa"];
  $where = " and ";
}

if (isset($jsonEntrada["idDemanda"]) && $jsonEntrada["idDemanda"] !== "") {
  $sql = $sql . $where . " tarefa.idDemanda = " . $jsonEntrada["idDemanda"];
  $where = " and ";
}

if (isset($jsonEntrada["idCliente"])) {
  $sql = $sql . $where . " tarefa.idCliente = " . $jsonEntrada["idCliente"];
  $where = " and ";
}

if (isset($jsonEntrada["idTipoOcorrencia"])) {
  $sql = $sql . $where . " tarefa.idTipoOcorrencia = " . $jsonEntrada["idTipoOcorrencia"];
  $where = " and ";
}

if (isset($jsonEntrada["idAtendente"])) {
  $sql = $sql . $where . " tarefa.idAtendente = " . $jsonEntrada["idAtendente"];
  $where = " and ";
}


$Periodo = 1;
if (isset($jsonEntrada["Periodo"])) {
  $Periodo = $jsonEntrada["Periodo"];
}
if (isset($jsonEntrada["statusTarefa"]) && $Periodo != 0) {
  if ($jsonEntrada["statusTarefa"] == 1) {
    $sql = $sql . $where . " tarefa.horaFinalReal IS NULL";
    $where = " and ";
  }
  if ($jsonEntrada["statusTarefa"] == 0) {
    $sql = $sql . $where . " tarefa.horaFinalReal IS NOT NULL";
    $where = " and ";
  }
}

if (isset($jsonEntrada["tituloTarefa"])) {
  //gabriel 16102023 ajustado buscar tarefa por titulo
  $sql = $sql . $where . " tarefa.idTarefa= " . "'" . $jsonEntrada["tituloTarefa"] . "'" 
                       . " or tarefa.tituloTarefa like " . "'%" . $jsonEntrada["tituloTarefa"] . "%'"
                       . " or (demanda.tituloDemanda is not null and demanda.tituloDemanda like " . "'%" . $jsonEntrada["tituloTarefa"] . "%')";
  $where = " and ";
}


if (isset($jsonEntrada["Periodo"])) {
  if ($jsonEntrada["Periodo"] == 1) {
    if (isset($jsonEntrada["PeriodoInicio"])) {
      $sql .= $where . " tarefa.Previsto >= '" . $jsonEntrada["PeriodoInicio"] . "'";
      $where = " and ";
    }
    if (isset($jsonEntrada["PeriodoFim"])) {
      $sql .= $where . " tarefa.Previsto <= '" . $jsonEntrada["PeriodoFim"] . "'";
      $where = " and ";
    }
  }
  if ($jsonEntrada["Periodo"] == 0) {
    if (isset($jsonEntrada["PeriodoInicio"])) {
      $sql .= $where . " tarefa.dataReal >= '" . $jsonEntrada["PeriodoInicio"] . "'";
      $where = " and ";
    }
    if (isset($jsonEntrada["PeriodoFim"])) {
      $sql .= $where . " tarefa.dataReal <= '" . $jsonEntrada["PeriodoFim"] . "'";
      $where = " and ";
    }

  }
}

$order = " ORDER BY ";
if (isset($jsonEntrada["PrevistoOrdem"])) {
  if ($jsonEntrada["PrevistoOrdem"] == 1) {
    $sql .= $order . " `tarefa`.`Previsto` DESC ";
    $order = ",";
  }
  if ($jsonEntrada["PrevistoOrdem"] == 0) {
    $sql .= $order . " `tarefa`.`Previsto` ASC ";
    $order = ",";
  }
}

if (isset($jsonEntrada["RealOrdem"])) {
  if ($jsonEntrada["RealOrdem"] == 1) {
    $sql .= $order . " `tarefa`.`dataReal` DESC ";
    $order = ",";
  }
  if ($jsonEntrada["RealOrdem"] == 0) {
    $sql .= $order . " `tarefa`.`dataReal` ASC ";
    $order = ",";
  }
}
$sql .= $order . " idTarefa DESC ";

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
    array_push($tarefa, $row);
    $rows = $rows + 1;
  }
  if (isset($jsonEntrada["idTarefa"]) && $rows == 1) {
    $tarefa = $tarefa[0];
  }
  $jsonSaida = $tarefa;

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



?>