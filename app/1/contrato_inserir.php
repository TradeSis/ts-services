<?php
// Lucas 20022023 alterado if para resultar no $valorHora e adicionado o else para $valorContrato;
// Lucas 07022023 criacao

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."contrato_inserir";
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

if (isset($jsonEntrada['tituloContrato'])) {
        $tituloContrato = $jsonEntrada['tituloContrato'];
        $descricao = $jsonEntrada['descricao'];
        $idContratoStatus = $jsonEntrada['idContratoStatus'];

        $dataPrevisao = isset($jsonEntrada['dataPrevisao']) && $jsonEntrada['dataPrevisao'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataPrevisao']) . "'" : "0000-00-00";
        $dataEntrega = isset($jsonEntrada['dataEntrega']) && $jsonEntrada['dataEntrega'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['dataEntrega']) . "'" : "0000-00-00";

		$idCliente = $jsonEntrada['idCliente'];
         
        if($jsonEntrada['horas'] == ''){
            $horas = 0;
        }else{
            $horas = $jsonEntrada['horas'];
        }
        if($jsonEntrada['valorHora'] == ''){
            $valorHora = 0;
        }else{
            $valorHora = $jsonEntrada['valorHora'];
        }
 
		$valorContrato = $jsonEntrada['valorContrato'];

		$statusContrato = null; 

        $idContratoTipo = $jsonEntrada['idContratoTipo'];

        if (($horas !== "") && ($valorContrato !== "")) {
			$valorHora = $valorContrato / $horas;
		} else{
            if (($horas !== "") && ($valorHora !== "")) {
                $valorContrato= $horas * $valorHora;
            }
        }
      
         //busca dados contratostatus    
    $sql2 = "SELECT * FROM contratostatus WHERE idContratoStatus = $idContratoStatus";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    if($row["mudaStatusPara"] == null){
        $statusContrato = "null";
    }else{
        $statusContrato = $row["mudaStatusPara"];
    }
    /* $statusContrato = $row["mudaStatusPara"]; */
    /* $statusContrato = isset($row["mudaStatusPara"]) && $row["mudaStatusPara"] == "" ? mysqli_real_escape_string($conexao, $row["mudaStatusPara"]) : "NULL"; */
    /* echo 'ROW' . json_encode($statusContrato); */
//LOG
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL>=3) {
        fwrite($arquivo,$identificacao."-SQL2 CONTRATO STATUS->".$sql2."\n");
    }
}
//LOG
    $sql = "INSERT INTO contrato (tituloContrato, descricao, dataAbertura, idContratoStatus, dataPrevisao, dataEntrega, idCliente, statusContrato, horas, valorHora, valorContrato, idContratoTipo) values ('$tituloContrato', '$descricao', CURRENT_TIMESTAMP(), $idContratoStatus, $dataPrevisao, $dataEntrega, $idCliente, $statusContrato, $horas, $valorHora, '$valorContrato', '$idContratoTipo')";

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