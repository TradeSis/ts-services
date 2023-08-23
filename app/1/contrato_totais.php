<?php
// Lucas 07022023 criacao

$conexao = conectaMysql();
$totais = array();

$sql = "
SELECT  contrato.idContratoStatus, 
        contratostatus.nomeContratoStatus, 
        count(*) as 'qtdContratos' , 
        sum(contrato.valorContrato) as 'valorContratos'
FROM contrato , contratostatus
where 
    contrato.idContratoStatus = contratostatus.idContratoStatus
group BY 
    contrato.idContratoStatus, contratostatus.nomeContratoStatus
";
/*if (isset($jsonEntrada["idContrato"])) {
  $sql = $sql . " where contrato.idContrato = " . $jsonEntrada["idContrato"];
}*/

//echo "-SQL->".$sql."\n";

$total = array();
$valorContratos = 0;
$qtdContratos = 0;

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  $valorContratos = $valorContratos + $row["valorContratos"] ;
  $qtdContratos = $qtdContratos + $row["qtdContratos"] ;   
  array_push($totais, $row);
  $rows = $rows + 1;
}
$total = array(
    "idContratoStatus" => "0",
    "nomeContratoStatus" => "Total",
    "qtdContratos" => $qtdContratos,
    "valorContratos" => $valorContratos
);

array_push($totais, $total);
/*
if (isset($jsonEntrada["idContrato"]) && $rows==1) {
  $contrato = $contrato[0];
}
*/
$jsonSaida = $totais;

//echo "-SAIDA->".json_encode($jsonSaida)."\n";


?>