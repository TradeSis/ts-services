<?php
// Gabriel 26022024 criacao

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."orcamento_inserir";
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=1) {
            $arquivo = fopen(defineCaminhoLog()."orcamento_".date("dmY").".log","a");
        }
    }
    
}
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL==1) {
        fwrite($arquivo,$identificacao."\n");
    }
    if ($LOG_NIVEL>=2) {
        fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");
    }
}
//LOG

$idEmpresa = null;
	if (isset($jsonEntrada["idEmpresa"])) {
    	$idEmpresa = $jsonEntrada["idEmpresa"];
	}
$conexao = conectaMysql($idEmpresa);

if (isset($jsonEntrada['tituloOrcamento'])) {
        $tituloOrcamento = "'" . $jsonEntrada['tituloOrcamento'] . "'";
        $descricao = "'" . $jsonEntrada['descricao'] . "'";
        $idCliente = isset($jsonEntrada['idCliente']) && $jsonEntrada['idCliente'] !== "" ? "'" . $jsonEntrada['idCliente'] . "'" : "NULL";
        $horas = isset($jsonEntrada['horas']) && $jsonEntrada['horas'] !== "" ? "'" . $jsonEntrada['horas'] . "'" : "0";
        $valorHora = isset($jsonEntrada['valorHora']) && $jsonEntrada['valorHora'] !== "" ? "'" . $jsonEntrada['valorHora'] . "'" : "0";
        $valorOrcamento = isset($jsonEntrada['valorOrcamento']) && $jsonEntrada['valorOrcamento'] !== "" ? "'" . $jsonEntrada['valorOrcamento'] . "'" : "NULL";
		$statusOrcamento = 1; //Aberto


    $sql = "INSERT INTO orcamento (tituloOrcamento, descricao, dataAbertura, idCliente, horas, valorHora, valorOrcamento, statusOrcamento) values ($tituloOrcamento, $descricao, CURRENT_TIMESTAMP(), $idCliente, $horas, $valorHora, $valorOrcamento, $statusOrcamento)";

    //LOG
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=3) {
            fwrite($arquivo,$identificacao."-SQL->".$sql."\n");
        }
    }
    //LOG

    //TRY-CATCH
      try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
         throw New Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );

    } catch (Exception $e){
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL>=1) {
            fwrite($arquivo,$identificacao."-ERRO->".$e->getMessage()."\n");
        }

    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH
        
 
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );

}

//LOG
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL>=2) {
        fwrite($arquivo,$identificacao."-SAIDA->".json_encode($jsonSaida)."\n\n");
    }
}
//LOG

?>