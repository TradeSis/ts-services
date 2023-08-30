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
		
		
        if($jsonEntrada['dataPrevisao'] == ''){
            $dataPrevisao = '0000-00-00';
        }else{
            $dataPrevisao = $jsonEntrada['dataPrevisao'];
        }
        if($jsonEntrada['dataEntrega'] == ''){
            $dataEntrega = '0000-00-00';
        }else{
            $dataEntrega = $jsonEntrada['dataEntrega'];
        }
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
		$statusContrato = $jsonEntrada['statusContrato']; 
        $idContratoTipo = $jsonEntrada['idContratoTipo'];

        //LOG
        if(isset($LOG_NIVEL)) {
            if ($LOG_NIVEL>=3) {
                fwrite($arquivo,$identificacao."-valorContrato->".$valorContrato."\n");
                fwrite($arquivo,$identificacao."-horas->".$horas."\n");
            }
        }
        //LOG

        if (($horas !== "") && ($valorContrato !== "")) {
			$valorHora = $valorContrato / $horas;
		} else{
            if (($horas !== "") && ($valorHora !== "")) {
                $valorContrato= $horas * $valorHora;
            }
        }
      

    $sql = "INSERT INTO contrato (xxtituloContrato, descricao, dataAbertura, idContratoStatus, dataPrevisao, dataEntrega, idCliente, statusContrato, horas, valorHora, valorContrato, idContratoTipo) values ('$tituloContrato', '$descricao', CURRENT_TIMESTAMP(), '$idContratoStatus', '$dataPrevisao', '$dataEntrega', '$idCliente', '$statusContrato', $horas, $valorHora, '$valorContrato', '$idContratoTipo')";
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