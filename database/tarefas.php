<?php
// helio 21032023 - compatibilidade chamada chamaApi
// gabriel 06022023 calculo timediff
// gabriel 15:10

include_once('../conexao.php');

function buscaTarefas($idDemanda = null)
{

    $tarefas = array();
    $apiEntrada = array(
        'idDemanda' => $idDemanda,
    );
    $tarefas = chamaAPI(null, '/api/services/tarefas', json_encode($apiEntrada), 'GET');
    return $tarefas;
}
function buscaHoras($idDemanda)
{

    $horas = array();
    $apiEntrada = array(
        'idDemanda' => $idDemanda,
    );
    $horas = chamaAPI(null, '/api/services/horas', json_encode($apiEntrada), 'GET');
    return $horas;
}

if (isset($_GET['operacao'])) {

    $operacao = $_GET['operacao'];

    if ($operacao == "inserir") {
        $apiEntrada = array(
            'tituloTarefa' => $_POST['tituloTarefa'],
            'idCliente' => $_POST['idCliente'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'dataExecucaoInicio' => $_POST['dataExecucaoInicio'],
            'dataExecucaoFinal' => $_POST['dataExecucaoFinal'],
            'idStatus' => $_POST['idStatus']
        );
        $tarefas = chamaAPI(null, '/api/services/tarefas', json_encode($apiEntrada), 'PUT');
    }

/*
    include "../demandas/tarefas_ok.php";
*/ 
    header('Location: ../demandas/tarefas.php');
}
