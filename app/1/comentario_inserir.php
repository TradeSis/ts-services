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
    
    $enviaEmailComentario = $jsonEntrada['enviaEmailComentario'];

    //Busca dados Demanda
    $sql_consulta1 = "SELECT * FROM demanda WHERE idDemanda = $idDemanda";
    $buscar_consulta1 = mysqli_query($conexao, $sql_consulta1);
    $row_consulta1 = mysqli_fetch_array($buscar_consulta1, MYSQLI_ASSOC);
    $tituloDemanda = $row_consulta1["tituloDemanda"];
    $idContratoTipo = $row_consulta1["idContratoTipo"];
    $idCliente = $row_consulta1['idCliente'];

    //Busca dados de usuario
    $sql_consulta = "SELECT * FROM usuario WHERE idUsuario = $idUsuario";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    $nomeUsuario = $row_consulta["nomeUsuario"];
    $email = $row_consulta["email"];

    $sql = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario,nomeAnexo,pathAnexo) VALUES ($idDemanda,'$comentario',$idUsuario,CURRENT_TIMESTAMP(),'$nomeAnexo','$pathAnexo')";

    if ($enviaEmailComentario != '') {
        //Envio de Email
        $tituloEmail = $nomeUsuario . ' adicionou um novo comentário em ' . $idContratoTipo . ' : ' . $tituloDemanda . '.';
        $corpoEmail = $comentario ;

        $arrayPara = array(

            array(
                'email' => 'tradesis@tradesis.com.br',
                'nome' => 'TradeSis'
            ),
            array(
                'email' => $email,
                'nome' => $nomeUsuario
            ),
        );

        $envio = emailEnviar(null, null, $arrayPara, $tituloEmail, $corpoEmail);
    }


    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");

        }
    }
    //LOG

    //TRY-CATCH
    try {
        $atualizar = mysqli_query($conexao, $sql);

        if (!$atualizar )
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