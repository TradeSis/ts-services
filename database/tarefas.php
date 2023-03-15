<?php
// gabriel 06022023 calculo timediff
// gabriel 15:10

include_once('../conexao.php');

function buscaTarefas($idTarefa = null)
{

    $tarefas = array();
    $apiEntrada = array(
        'idTarefa' => $idTarefa,
    );
    $tarefas = chamaAPI('tarefas', 'tarefas', json_encode($apiEntrada), 'GET');
    return $tarefas;
}
function buscaHoras($idDemanda)
{

    $horas = array();
    $apiEntrada = array(
        'idDemanda' => $idDemanda,
    );
    $horas = chamaAPI('horas', 'horas', json_encode($apiEntrada), 'GET');
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
        $tarefas = chamaAPI('tarefas', 'tarefas', json_encode($apiEntrada), 'PUT');
    }

/*
    include "../demandas/tarefas_ok.php";
*/ 
    header('Location: ../demandas/tarefas.php');
}
