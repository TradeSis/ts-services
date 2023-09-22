<?php
//lucas 22092023 ID 358 Demandas/Comentarios 
//gabriel 07022023 16:25
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

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
    $pathAnexo = $jsonEntrada['pathAnexo'];
    $nomeAnexo = $jsonEntrada['nomeAnexo'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $idAtendente = $jsonEntrada['idAtendente'];


    $sql = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario,nomeAnexo,pathAnexo) VALUES ($idDemanda,'$comentario',$idUsuario,CURRENT_TIMESTAMP(),'$nomeAnexo','$pathAnexo')";
    $atualizar = mysqli_query($conexao, $sql);

    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];


    if ($idTipoStatus === null) {
        $sql3 = "UPDATE demanda SET posicao=$posicao, dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        $atualizar3 = mysqli_query($conexao, $sql3);
    } else {
        //lucas 22092023 ID 358 Adicionado idAtendente
        $sql3 = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, idAtendente=$idAtendente , dataAtualizacaoAtendente=CURRENT_TIMESTAMP(), statusDemanda=$statusDemanda WHERE idDemanda = $idDemanda";
        $atualizar3 = mysqli_query($conexao, $sql3);
    }

    if ($atualizar && $atualizar3) {
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } else {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => "erro no mysql"
        );
    }
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parâmetros"
    );
}