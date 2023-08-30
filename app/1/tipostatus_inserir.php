<?php
//gabriel 06022023 16:52
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."tipostatus_inserir";
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=1) {
            $arquivo = fopen(defineCaminhoLog()."services_".date("dmY").".log","a");
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
if (isset($jsonEntrada['nomeTipoStatus'])) {
    $nomeTipoStatus = $jsonEntrada['nomeTipoStatus'];
    $mudaPosicaoPara = $jsonEntrada['mudaPosicaoPara'];
    $mudaStatusPara = $jsonEntrada['mudaStatusPara'];
    $statusInicial = 0;
    $sql = "INSERT INTO tipostatus (nomeTipoStatus, mudaPosicaoPara, mudaStatusPara, statusInicial) values ('$nomeTipoStatus', $mudaPosicaoPara, $mudaStatusPara, $statusInicial)";

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