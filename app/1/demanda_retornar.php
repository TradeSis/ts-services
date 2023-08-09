<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$idEmpresa = null;
	if (isset($jsonEntrada["idEmpresa"])) {
    	$idEmpresa = $jsonEntrada["idEmpresa"];
	}
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idDemanda'])) {
    $idDemanda = $jsonEntrada['idDemanda'];
    $idTipoStatus = $jsonEntrada['idTipoStatus'];
    $comentario = $jsonEntrada['comentario'];
    $idUsuario = $jsonEntrada['idUsuario'];
    $idCliente = $jsonEntrada['idCliente'];
    //$idAnexo = $jsonEntrada['idAnexo'];
    //$pathAnexo = $jsonEntrada['pathAnexo'];
    //$nomeAnexo = $jsonEntrada['nomeAnexo'];

    if($comentario==''){$comentario=null;}

    // busca dados tipostatus    
    $sql2 = "SELECT * FROM tipostatus WHERE idTipoStatus = $idTipoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $posicao = $row["mudaPosicaoPara"];
    $statusDemanda = $row["mudaStatusPara"];
    
    $sql = "UPDATE demanda SET posicao=$posicao, idTipoStatus=$idTipoStatus, dataFechamento=NULL, statusDemanda=$statusDemanda, dataAtualizacaoCliente=CURRENT_TIMESTAMP(), QtdRetornos=QtdRetornos+1 WHERE idDemanda = $idDemanda;";
    $atualizar = mysqli_query($conexao, $sql);
    
    if ($comentario!=null) {
    $sql3 = "INSERT INTO comentario(idDemanda, comentario, idUsuario, dataComentario) VALUES ($idDemanda,'$comentario',$idUsuario,CURRENT_TIMESTAMP())";
    $atualizar3 = mysqli_query($conexao, $sql3); }
    

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