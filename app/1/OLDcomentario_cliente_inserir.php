<?php
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "comentario_cliente_inserir";
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
if (isset($jsonEntrada['idDemanda'])) {
    $idDemanda = $jsonEntrada['idDemanda'];
    $comentario = $jsonEntrada['comentario'];
    $idUsuario = $jsonEntrada['idUsuario'];
    $idCliente = $jsonEntrada['idCliente'];
    //$idAnexo = $jsonEntrada['idAnexo'];
    //$pathAnexo = $jsonEntrada['pathAnexo'];
    //$nomeAnexo = $jsonEntrada['nomeAnexo'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $tipoStatusDemanda = $jsonEntrada['tipoStatusDemanda'];


    $sql = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda,'$comentario',$idUsuario,CURRENT_TIMESTAMP())";

    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];


    if ($tipoStatusDemanda == TIPOSTATUS_AGUARDANDOSOLICITANTE) {
        $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoCliente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
    } else {
        $sql3 = "UPDATE demanda SET posicao=$posicao, dataAtualizacaoCliente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            fwrite($arquivo, $identificacao . "-SQL3->" . $sql3 . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {
        $atualizar = mysqli_query($conexao, $sql);
        $atualizar3 = mysqli_query($conexao, $sql3);
           if (!$atualizar && !$atualizar3)
                throw new Exception(mysqli_error($conexao));
    
       
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
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

} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parâmetros"
    );
}