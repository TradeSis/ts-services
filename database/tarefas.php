<?php
// helio 21032023 - compatibilidade chamada chamaApi
// gabriel 06022023 calculo timediff
// gabriel 15:10
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include_once __DIR__ . "/../conexao.php";

function buscaTarefas($idDemanda = null, $idTarefa = null)
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

    $idEmpresa = null;
    if (isset($_SESSION['idEmpresa'])) {
        $idEmpresa = $_SESSION['idEmpresa'];
    }

    $apiEntrada = array(
        'idEmpresa' => $idEmpresa
    );
    $dadosGrafico2 = array();
    $dadosGrafico2 = chamaAPI(null, '/services/tarefas/grafico2', json_encode($apiEntrada), 'GET');
    return $dadosGrafico2;
}
function buscaTarefasGrafico3()
{

    $idEmpresa = null;
    if (isset($_SESSION['idEmpresa'])) {
        $idEmpresa = $_SESSION['idEmpresa'];
    }

    $apiEntrada = array(
        'idEmpresa' => $idEmpresa
    );
    $dadosGrafico3 = array();

    $dadosGrafico3 = chamaAPI(null, '/services/tarefas/grafico3', json_encode($apiEntrada), 'GET');
    return $dadosGrafico3;
}

function buscaTarefasGrafico4()
{
    $idEmpresa = null;
    if (isset($_SESSION['idEmpresa'])) {
        $idEmpresa = $_SESSION['idEmpresa'];
    }

    $apiEntrada = array(
        'idEmpresa' => $idEmpresa
    );

    $dadosGrafico4 = array();
    $dadosGrafico4 = chamaAPI(null, '/services/tarefas/grafico4', json_encode($apiEntrada), 'GET');
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
        'idEmpresa' => $idEmpresa,
        'idDemanda' => $idDemanda
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
            'idTipoStatus' => $_POST['idTipoStatus'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
            'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
            'Previsto' => $_POST['Previsto'],
            'horaInicioPrevisto' => $_POST['horaInicioPrevisto'],
            'horaFinalPrevisto' => $_POST['horaFinalPrevisto'],
            'horaCobrado' => $_POST['horaCobrado']
        );
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'PUT');

        header('Location: ../demandas/visualizar.php?id=tarefas&&idDemanda=' . $apiEntrada['idDemanda']);
    }

    if ($operacao == "alterar") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'idDemandaSelect' => $_POST['idDemandaSelect'],
            'idAtendente' => $_POST['idAtendente'],
            'tituloTarefa' => $_POST['tituloTarefa'],
            'idTipoOcorrencia' => $_POST['idTipoOcorrencia'],
            'horaCobrado' => $_POST['horaCobrado'],
            'dataReal' => $_POST['dataReal'],
            'horaInicioReal' => $_POST['horaInicioReal'],
            'horaFinalReal' => $_POST['horaFinalReal'],
            'Previsto' => $_POST['Previsto'],
            'horaInicioPrevisto' => $_POST['horaInicioPrevisto'],
            'horaFinalPrevisto' => $_POST['horaFinalPrevisto']
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

    if ($operacao == "realizado") {
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $_POST['idTarefa'],
            'idDemanda' => $_POST['idDemanda'],
            'tipoStatusDemanda' => $_POST['tipoStatusDemanda'],
            'idTipoStatus' => TIPOSTATUS_PAUSADO
        );
        $tarefas = chamaAPI(null, '/services/tarefas/realizado', json_encode($apiEntrada), 'POST');
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

    if ($operacao == "filtrar") {

        $idCliente = $_POST['idCliente'];
        $idAtendente = $_POST['idAtendente'];
        $tituloTarefa = $_POST['tituloTarefa'];
        $idTipoOcorrencia = $_POST['idTipoOcorrencia'];
        $statusTarefa = $_POST['statusTarefa'];
        $periodo = $_POST['periodo'];
        $inicio = $_POST['inicio'];
        $final = $_POST['final'];

        if ($idCliente == "") {
            $idCliente = null;
        }
        if ($idAtendente == "") {
            $idAtendente = null;
        }
        if ($tituloTarefa == "") {
            $tituloTarefa = null;
        }
        if ($idTipoOcorrencia == "") {
            $idTipoOcorrencia = null;
        }
        if ($statusTarefa == "") {
            $statusTarefa = null;
        }
        if ($periodo == "") {
            $periodo = null;
        }
        if ($inicio == "") {
            $inicio = null;
        }
        if ($final == "") {
            $final = null;
        }

        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idCliente' => $idCliente,
            'idAtendente' => $idAtendente,
            'tituloTarefa' => $tituloTarefa,
            'idTipoOcorrencia' => $idTipoOcorrencia,
            'statusTarefa' => $statusTarefa,
            'periodo' => $periodo,
            'inicio' => $inicio,
            'final' => $final
        );

        $_SESSION['filtro_tarefas'] = $apiEntrada;
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'GET');

        echo json_encode($tarefas);
        return $tarefas;
    }

    if ($operacao == "buscar") {
        $idTarefa = $_POST['idTarefa'];
        if ($idTarefa == "") {
            $idTarefa = null;
        }
        $apiEntrada = array(
            'idEmpresa' => $idEmpresa,
            'idTarefa' => $idTarefa
        );
        $tarefas = chamaAPI(null, '/services/tarefas', json_encode($apiEntrada), 'GET');

        echo json_encode($tarefas);
        return $tarefas;
    }



    /*
        include "../demandas/tarefas_ok.php";
    */
    //header('Location: ../demandas/tarefas.php');
}