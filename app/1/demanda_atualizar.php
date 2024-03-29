<?php
//lucas 22092023 ID 358 Demandas/Comentarios 
//gabriel 220323
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

/* 
Exemplo de entrada :
{"idEmpresa":"1","idDemanda":"749","idUsuario":"14","idCliente":"1","comentario":"<p>texto<\/p>","idAtendente":null,"acao":"entregar"}
{"idEmpresa":"1","idDemanda":"749","idUsuario":"14","idCliente":"1","comentario":"<p>texto<\/p>","idAtendente":null,"acao":"retornar"}
{"idEmpresa":"1","idDemanda":"748","idUsuario":"14","idCliente":"1","comentario":"<p>texto<\/p>","idAtendente":null,"acao":"validar"} 
{"idEmpresa":"1","idDemanda":"749","idUsuario":"14","idCliente":"1","comentario":"<p>texto<\/p>","idAtendente":"10","acao":"solicitar"}
*/

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "demanda_atualizar";
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
    $idUsuario = $jsonEntrada['idUsuario'];
    $comentario = isset($jsonEntrada['comentario']) && $jsonEntrada['comentario'] !== "null" && $jsonEntrada['comentario'] !== "" ? "'" . $jsonEntrada['comentario'] . "'" : "null";
    $idAtendenteEncaminhar = $jsonEntrada['idAtendente']; // Encaminhar  

    //Busca data de fechamento atual
    $sql_consulta = "SELECT idDemanda,dataFechamento,tituloDemanda,idContratoTipo,idAtendente FROM demanda WHERE idDemanda = $idDemanda";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    $dataFechamento = isset($row_consulta["dataFechamento"])  && $row_consulta["dataFechamento"] !== "" && $row_consulta["dataFechamento"] !== "null" ? "'". $row_consulta["dataFechamento"]."'"  : "null";
    $tituloDemanda = $row_consulta["tituloDemanda"];
    $idContratoTipo = $row_consulta["idContratoTipo"];
    $idAtendente = $row_consulta["idAtendente"];
    
    if ($idAtendente == null) { $idAtendente = $idAtendenteEncaminhar; }

    //Busca dados de usuario
    $sql_consulta = "SELECT * FROM usuario WHERE idUsuario = $idAtendente";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    $nomeUsuario = $row_consulta["nomeUsuario"];
    $email = $row_consulta["email"] ;

    //REALIZADO
    if ($jsonEntrada['acao'] == "entregar") { 
        
        $idTipoStatus = TIPOSTATUS_REALIZADO;
        $nomeStatusEmail = 'REALIZADO';

        //Busca dados tipostatus    
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        //lucas 22092023 ID 358 modificado o teste para gravar a data quando for tipo encerrado
        if (($statusDemanda == 3) && ($dataFechamento === 'null')) { //se status for do tipo encerrar
                $dataFechamento = 'CURRENT_TIMESTAMP ()'; //grava a data de fechamento      
        } 

        $sql = "UPDATE demanda SET posicao = $posicao, idTipoStatus = $idTipoStatus, dataFechamento = $dataFechamento, dataAtualizacaoAtendente = CURRENT_TIMESTAMP(), 
        statusDemanda = $statusDemanda  WHERE demanda.idDemanda = $idDemanda ";

    }


    //RETORNAR
    if ($jsonEntrada['acao'] == "retornar") {
        
        $idTipoStatus = TIPOSTATUS_RETORNO;
        $nomeStatusEmail = 'RETORNO';

        //Busca dados tipostatus     
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataFechamento=NULL, statusDemanda=$statusDemanda, dataAtualizacaoCliente=CURRENT_TIMESTAMP(), QtdRetornos=QtdRetornos+1 WHERE idDemanda = $idDemanda;";

    }

    //RESPONDER
    if ($jsonEntrada['acao'] == "responder") {
        
        $idTipoStatus = TIPOSTATUS_RESPONDIDO;
        $nomeStatusEmail = 'RESPONDIDO';

        //Busca dados tipostatus     
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, statusDemanda=$statusDemanda, dataAtualizacaoCliente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda;";

    }

    //DEVOLVER
    if ($jsonEntrada['acao'] == "devolver") {
        
        $idTipoStatus = TIPOSTATUS_AGUARDANDOSOLICITANTE;
        $nomeStatusEmail = 'DEVOLVIDO';

        //Busca dados tipostatus     
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, statusDemanda=$statusDemanda, dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda;";

    }


    //VALIDAR
    if ($jsonEntrada['acao'] == "validar") {
        
        $idTipoStatus = TIPOSTATUS_VALIDADO;
        $nomeStatusEmail = 'VALIDADO';

        //Busca dados tipostatus    
        $sql_consulta = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
        $buscar_consulta = mysqli_query($conexao, $sql_consulta);
        $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
        $posicao = $row_consulta["mudaPosicaoPara"];
        $statusDemanda = $row_consulta["mudaStatusPara"];

        if ($dataFechamento === 'null') {
            $dataFechamento = 'CURRENT_TIMESTAMP ()';
        } 
        $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataAtualizacaoCliente=CURRENT_TIMESTAMP(),dataFechamento = $dataFechamento, statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";

    }

    //RETORNAR
    if ($jsonEntrada['acao'] == "encaminhar") {

        //lucas 22092023 ID 358 Adicionado idAtendente
        $sql = "UPDATE demanda SET idAtendente=$idAtendenteEncaminhar , dataAtualizacaoAtendente=CURRENT_TIMESTAMP() WHERE idDemanda = $idDemanda";
        
    }

    if ($comentario !== "null") {
        $sql_insert_comentario = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda, $comentario ,$idUsuario,CURRENT_TIMESTAMP())";
    }

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
            if (isset($sql_insert_comentario)) {
                fwrite($arquivo, $identificacao . "-SQL INSERT COMENTARIOS ->" . $sql_insert_comentario . "\n");
            }
        }
    }
    

    
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        if (isset($sql_insert_comentario)) {
            $atualizar2 = mysqli_query($conexao, $sql_insert_comentario);
            if (!$atualizar2)
                throw new Exception(mysqli_error($conexao));
        }
    
        //Envio de Email
        $tituloEmail = $tituloDemanda;
        $corpoEmail = $idContratoTipo . ' : ' . $tituloDemanda. '<br>' .
        ' entrou no status: ' . $nomeStatusEmail;

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

        $envio = emailEnviar(null,null,$arrayPara,$tituloEmail,$corpoEmail);
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
        "retorno" => "Faltaram parametros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG