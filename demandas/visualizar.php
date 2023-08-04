<?php

include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/contratos.php';
include_once '../database/tarefas.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';
include_once(ROOT.'/sistema/database/clientes.php');
include_once(ROOT.'/sistema/database/usuario.php');
include_once(ROOT.'/sistema/database/servicos.php');

$idDemanda = $_GET['idDemanda'];
$idAtendente = $_SESSION['idUsuario'];
$ocorrencias = buscaTipoOcorrencia();
$tiposstatus = buscaTipoStatus();
$demanda = buscaDemandas($idDemanda);
$contratos = buscaContratosAbertos();
$servicos = buscaServicos();
$idTipoStatus = $demanda['idTipoStatus'];
$horas = buscaHoras($idDemanda);
$atendentes = buscaAtendente();
$usuario = buscaUsuarios($_SESSION['idUsuario']);
$comentarios = buscaComentarios($idDemanda);
$cliente = buscaClientes($demanda["idCliente"]);
$idTarefa = null;

if (isset($_GET['idTarefa'])) {
    $idTarefa = $_GET['idTarefa'];
}

$tarefas = buscaTarefas($idDemanda, $idTarefa);

?>


<style>
    body {
        margin-bottom: 30px;
    }

    .line {
        width: 100%;
        border-bottom: 1px solid #707070;
    }

    #tabs .tab {
        display: inline-block;
        padding: 5px 10px;
        cursor: pointer;
        position: relative;
        z-index: 5;
        background-color: lightgray;
        color: black;
    }

    #tabs .whiteborder {
        border: 1px solid #707070;
        border-bottom: 1px solid #fff;
        border-radius: 3px 3px 0 0;
        background-color: lightblue;
        color: white;
    }

    #tabs .tabContent {
        position: relative;
        top: -1px;
        z-index: 1;
        padding: 10px;
        border-radius: 0 0 3px 3px;
        color: black;
    }

    #tabs .hide {
        display: none;
    }

    #tabs .show {
        display: block;
    }
</style>

<body class="bg-transparent">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm mt-3" style="text-align:left;margin-left:50px;">
                <span class="titulo">Chamado -
                    <?php echo $idDemanda ?>
                </span>
            </div>
            <div class="col-sm mt-3" style="text-align:right;margin-right:50px;">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i>&#32;Voltar</a>
            </div>
        </div>
        <div id="tabs">
            <div class="tab whiteborder" id="tab-demanda">Demanda</div>
            <div class="tab" id="tab-comentarios">Comentarios</div>
            <div class="tab" id="tab-tarefas">Tarefas</div>
            <div class="tab" id="tab-previsao">Agenda</div>
            <div class="line"></div>
            <div class="tabContent">
                <?php include_once 'visualizar_demanda.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'comentarios.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'visualizar_tarefa.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'previsao.php'; ?>
            </div>
        </div>
    </div>

    <script>
        var tab;
        var tabContent;

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'comentarios') {
                showTabsContent(1);
            }
            if (id === 'tarefas') {
                showTabsContent(2); 
            }
            if (id === 'previsao') {
                showTabsContent(3); 
            }
        }

        document.getElementById('tabs').onclick = function (event) {
            var target = event.target;
            if (target.className == 'tab') {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        }

        function hideTabsContent(a) {
            for (var i = a; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(b) {
            if (tabContent[b].classList.contains('hide')) {
                hideTabsContent(0);
                tab[b].classList.add('whiteborder');
                tabContent[b].classList.remove('hide');
                tabContent[b].classList.add('show');
            }
        }
    </script>
</body>

</html>