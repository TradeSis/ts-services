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
    $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'GET');
    return $tarefas;
}
function buscaTarefasGrafico1()
{

    $dadosGrafico1 = array();
    $dadosGrafico1 = chamaAPI(null, '/services/tarefas/grafico1', null, 'GET');
    return $dadosGrafico1;
}
function buscaTarefasGrafico2()
{

    $dadosGrafico2 = array();
    $dadosGrafico2 = chamaAPI(null, '/services/tarefas/grafico2', null, 'GET');
    return $dadosGrafico2;
}
function buscaTarefasGrafico3()
{

    $dadosGrafico3 = array();
    $dadosGrafico3 = chamaAPI(null, '/services/tarefas/grafico3', null, 'GET');
    return $dadosGrafico3;
}

function buscaTarefasGrafico4()
{

    $dadosGrafico4 = array();
    $dadosGrafico4 = chamaAPI(null, '/services/tarefas/grafico4', null, 'GET');
    return $dadosGrafico4;
}
function buscaHoras($idDemanda)
{

    $horas = array();
    $apiEntrada = array(
        'idDemanda' => $idDemanda,
    );
    $horas = chamaAPI(null, '/services/horas', json_encode($apiEntrada), 'GET');
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
            'data' => $_POST['data'],
            'horaInicio' => $_POST['horaInicio'],
            'horaFinal' => $_POST['horaFinal'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia']
        );
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'PUT');
    }

    if ($operacao == "start") {
        $apiEntrada = array(
            'tituloTarefa' => $_POST['tituloTarefa'],
            'idCliente' => $_POST['idCliente'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'data' => $_POST['data'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
            'idTipoStatus' => Fazendo

        );
        $tarefas = chamaAPI(null, '/services/tarefas/start', json_encode($apiEntrada), 'PUT');
    }

    if ($operacao == "startAlterar") {
        $apiEntrada = array(
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
            'idTipoStatus' => Fazendo
        );
        $tarefas = chamaAPI(null, '/services/tarefas/startAlterar', json_encode($apiEntrada), 'POST');
    }

    if ($operacao == "alterar") {
        $apiEntrada = array(
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'tituloTarefa' => $_POST['tituloTarefa'],
            'data' => $_POST['data'],
            'horaInicio' => $_POST['horaInicio'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
            'horaFinal' => $_POST['horaFinal']
        );
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'POST');
    }

    if ($operacao == "stop") {
        $apiEntrada = array(
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'horaInicio' => $_POST['horaInicio'],
            'idTipoStatus' => Pausado
        );
        $tarefas = chamaAPI(null, '/services/tarefas/stop', json_encode($apiEntrada), 'POST');
    }

    if ($operacao == "previsao") {
        $apiEntrada = array(
            'idCliente' => $_POST['idCliente'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'dataPrevisto' => $_POST['dataPrevisto'],
            'previsaoInicio' => $_POST['previsaoInicio'],
            'previsaoFim' => $_POST['previsaoFim'],
            'idTipoStatus' => Agendado
        );
        $tarefas = chamaAPI(null, '/services/previsao', json_encode($apiEntrada), 'PUT');
    }

    if ($operacao == "alterarPrevisao") {
        $apiEntrada = array(
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'dataPrevisto' => $_POST['dataPrevisto'],
            'previsaoInicio' => $_POST['previsaoInicio'],
            'previsaoFim' => $_POST['previsaoFim'],
            'idTipoStatus' => Agendado
        );
        $tarefas = chamaAPI(null, '/services/previsao', json_encode($apiEntrada), 'POST');
    }


/*
    include "../demandas/tarefas_ok.php";
*/ 
    //header('Location: ../demandas/tarefas.php');
}
