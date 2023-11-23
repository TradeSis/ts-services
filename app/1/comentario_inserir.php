<?php
//lucas 22112023 ID 688 Melhorias em Demandas 
//lucas 22092023 ID 358 Demandas/Comentarios 
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "comentario_inserir";
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


    $sql = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario,nomeAnexo,pathAnexo) VALUES ($idDemanda,'$comentario',$idUsuario,CURRENT_TIMESTAMP(),'$nomeAnexo','$pathAnexo')";
    
    $sql2 = "UPDATE demanda SET posicao=$posicao, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
    
    
//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 3) {
        fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        fwrite($arquivo, $identificacao . "-SQL 2->" . $sql2 . "\n");
    }
}
//LOG

 //TRY-CATCH
 try {
    $atualizar = mysqli_query($conexao, $sql);
    $atualizar2 = mysqli_query($conexao, $sql2);
       if (!$atualizar && !$atualizar2)
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

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG