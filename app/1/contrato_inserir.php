<?php
// Lucas 20022023 alterado if para resultar no $valorHora e adicionado o else para $valorContrato;
// Lucas 07022023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";


$conexao = conectaMysql();
if (isset($jsonEntrada['tituloContrato'])) {
        $tituloContrato = $jsonEntrada['tituloContrato'];
        $descricao = $jsonEntrada['descricao'];
        $idContratoStatus = $jsonEntrada['idContratoStatus'];
		$dataPrevisao = $jsonEntrada['dataPrevisao'];
		$dataEntrega = $jsonEntrada['dataEntrega'];
		$idCliente = $jsonEntrada['idCliente'];
        $horas = $jsonEntrada['horas'];
        $valorHora = $jsonEntrada['valorHora'];
		$valorContrato = $jsonEntrada['valorContrato'];
		$statusContrato = 0; //Fechado

    

        if (($horas !== "") && ($valorContrato !== "")) {
			$valorHora = $valorContrato / $horas;
		} else{
            if (($horas !== "") && ($valorHora !== "")) {
                $valorContrato= $horas * $valorHora;
            }
        }
      
	   
    $sql = "INSERT INTO contrato (tituloContrato, descricao, dataAbertura, idContratoStatus, dataPrevisao, dataEntrega, idCliente, statusContrato, horas, valorHora, valorContrato) values ('$tituloContrato', '$descricao', CURRENT_TIMESTAMP(), '$idContratoStatus', '$dataPrevisao', '$dataEntrega', '$idCliente', '$statusContrato', '$horas', '$valorHora', '$valorContrato')";
    if ($atualizar = mysqli_query($conexao, $sql)) {
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
        "retorno" => "Faltaram parametros"
    );

}

?>