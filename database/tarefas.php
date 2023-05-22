<?php
// helio 21032023 - compatibilidade chamada chamaApi
// gabriel 06022023 calculo timediff
// gabriel 15:10

include_once('../conexao.php');

function buscaTarefas($idDemanda=null,$idTarefa=null)
{

    $tarefas = array();
    $apiEntrada = array(
        'idDemanda' => $idDemanda,
        'idTarefa' => $idTarefa,
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

    if ($operacao == "start") {
        $apiEntrada = array(
            'tituloTarefa' => $_POST['tituloTarefa'],
            'idCliente' => $_POST['idCliente'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'idStatus' => $_POST['idStatus']
        );
        $tarefas = chamaAPI(null, '/api/services/tarefas/start', json_encode($apiEntrada), 'PUT');
    }

    if ($operacao == "alterar") {
        $apiEntrada = array(
            'idTarefa' => $_POST['idTarefa'],
            'tituloTarefa' => $_POST['tituloTarefa'],
            'dataExecucaoInicio' => $_POST['dataExecucaoInicio'],
            'dataExecucaoFinal' => $_POST['dataExecucaoFinal']
        );
        $tarefas = chamaAPI(null, '/api/services/tarefas', json_encode($apiEntrada), 'POST');
    }

    if ($operacao == "stop") {
        $apiEntrada = array(
            'idTarefa' => $_POST['idTarefa'],
            'dataExecucaoInicio' => $_POST['dataExecucaoInicio']
        );
        $tarefas = chamaAPI(null, '/api/services/tarefas/stop', json_encode($apiEntrada), 'POST');
    }

/*
    include "../demandas/tarefas_ok.php";
*/ 
    //header('Location: ../demandas/tarefas.php');
}
