<?php
// helio 21032023 - compatibilidade chamada chamaApi
// gabriel 06022023 calculo timediff
// gabriel 15:10

include_once __DIR__ . "/../conexao.php";

function buscaTarefas($idDemanda=null,$idTarefa=null)
{

    $tarefas = array();

    $idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}

    $apiEntrada = array(
        'idDemanda' => $idDemanda,
        'idTarefa' => $idTarefa,
        'idEmpresa' => $idEmpresa,
    );
    $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'GET');
    return $tarefas;
}
function buscaTarefasGrafico1()
{

    $dadosGrafico1 = array();
    $idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
    $apiEntrada = array(
        'idEmpresa' => $idEmpresa,
    );
    $dadosGrafico1 = chamaAPI(null, '/services/tarefas/grafico1', json_encode($apiEntrada), 'GET');
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

    $idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}

    $apiEntrada = array(
        'idDemanda' => $idDemanda,
        'idEmpresa' => $idEmpresa,
    );
    $horas = chamaAPI(null, '/services/horas', json_encode($apiEntrada), 'GET');
    return $horas;
}

if (isset($_GET['operacao'])) {

    $operacao = $_GET['operacao'];
    $idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
    if ($operacao == "inserir") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'tituloTarefa' => $_POST['tituloTarefa'],
            'idCliente' => $_POST['idCliente'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'dataCobrado' => $_POST['dataCobrado'],
            'horaInicioCobrado' => $_POST['horaInicioCobrado'],
            'horaFinalCobrado' => $_POST['horaFinalCobrado'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia']
        );
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'PUT');

        header('Location: ../demandas/visualizar.php?id=tarefas&&idDemanda=' . $apiEntrada['idDemanda']);
    }

    if ($operacao == "alterar") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'tituloTarefa' => $_POST['tituloTarefa'],
            'dataCobrado' => $_POST['dataCobrado'],
            'horaInicioCobrado' => $_POST['horaInicioCobrado'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
            'horaFinalCobrado' => $_POST['horaFinalCobrado']
        );
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'POST');
        
        header('Location: ../demandas/visualizar.php?id=tarefas&&idDemanda=' . $apiEntrada['idDemanda']);
    }

    if ($operacao == "start") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_FAZENDO
        );
        $tarefas = chamaAPI(null, '/services/tarefas/start', json_encode($apiEntrada), 'POST');
    }

    if ($operacao == "stop") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_PAUSADO
        );
        $tarefas = chamaAPI(null, '/services/tarefas/stop', json_encode($apiEntrada), 'POST');
    }

    if ($operacao == "previsao") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idCliente' => $_POST['idCliente'],
            'idDemanda' => $_POST['idDemanda'],
            'idAtendente' => $_POST['idAtendente'],
            'tituloTarefa' => $_POST['tituloTarefa'],
            'Previsto' => $_POST['Previsto'],
            'horaInicioPrevisto' => $_POST['horaInicioPrevisto'],
            'horaFinalPrevisto' => $_POST['horaFinalPrevisto'],
            'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_AGENDADO
        );
        $tarefas = chamaAPI(null, '/services/previsao', json_encode($apiEntrada), 'PUT');

        header('Location: ../demandas/visualizar.php?id=previsao&&idDemanda=' . $apiEntrada['idDemanda']);
    }

    if ($operacao == "alterarPrevisao") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'tituloTarefa' => $_POST['tituloTarefa'],
            'idAtendente' => $_POST['idAtendente'],
            'Previsto' => $_POST['Previsto'],
            'horaInicioPrevisto' => $_POST['horaInicioPrevisto'],
            'horaFinalPrevisto' => $_POST['horaFinalPrevisto'],
            'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_AGENDADO
        );
        $tarefas = chamaAPI(null, '/services/previsao', json_encode($apiEntrada), 'POST');

        header('Location: ../demandas/visualizar.php?id=previsao&&idDemanda=' . $apiEntrada['idDemanda']);
    }


/*
    include "../demandas/tarefas_ok.php";
*/ 
    //header('Location: ../demandas/tarefas.php');
}
