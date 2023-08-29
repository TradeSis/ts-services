<?php

include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/contratos.php';
include_once '../database/tarefas.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';

include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/servicos.php');


$idDemanda = $_GET['idDemanda'];
$idAtendente = $_SESSION['idLogin'];
$ocorrencias = buscaTipoOcorrencia();
$tiposstatus = buscaTipoStatus();
$demanda = buscaDemandas($idDemanda);
$contratos = buscaContratosAbertos();
$servicos = buscaServicos();
$idTipoStatus = $demanda['idTipoStatus'];
$horas = buscaHoras($idDemanda);
$atendentes = buscaAtendente();
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$comentarios = buscaComentarios($idDemanda);
$cliente = buscaClientes($demanda["idCliente"]);
$clientes = buscaClientes();
$tarefas = buscaTarefas($idDemanda);

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
    $ClienteSession = $_SESSION['idCliente'];
}

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
        border-radius: 3px 3px 0 0;
        background-color: #567381;
        color: #EEEEEE;
    }

    #tabs .whiteborder {
        border: 1px solid #707070;
        border-bottom: 1px solid #fff;
        border-radius: 3px 3px 0 0;
        background-color: #EEEEEE;
        color: #567381;
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

    .modal-backdrop {
        background-color: rgba(200, 200, 200, 0.5);
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
                <a href="index.php" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>
        <div id="tabs">
            <div class="tab whiteborder" id="tab-demanda">Demanda</div>
            <div class="tab" id="tab-comentarios">Comentarios</div>
            <?php if ($ClienteSession == NULL) { ?>
                <div class="tab" id="tab-tarefas">Tarefas</div>
            <?php } ?>
            <div class="line"></div>
            <div class="tabContent">
                <?php include_once 'visualizar_demanda.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'comentarios.php'; ?>
            </div>
            <?php if ($ClienteSession == NULL) { ?>
                <div class="tabContent">
                    <?php include_once 'visualizar_tarefa.php'; ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!--------- INSERIR/NOVA --------->
    <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" role="dialog"
        aria-labelledby="inserirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir Tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="form1">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                                <div class="form-group" style="margin-top: 22px;">
                                    <input type="text" class="form-control" name="tituloTarefa" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class='control-label' for='inputNormal' style="margin-top: 10px;">ID/Demanda
                                    Relacionada</label>
                                <div class="form-group" style="margin-top: 22px;">
                                    <input type="hidden" class="form-control" name="idDemanda"
                                        value="<?php echo $demanda['idDemanda'] ?>" style="margin-bottom: -20px;">
                                    <input type="text" class="form-control"
                                        value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>"
                                        readonly>
                                    <input type="hidden" name="tipoStatusDemanda" value="<?php echo $idTipoStatus ?>" />
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class='control-label' for='inputNormal' style="margin-top: 10px;">Cliente</label>
                                <div class="form-group" style="margin-top: 22px;">
                                    <input type="hidden" class="form-control" name="idCliente"
                                        value="<?php echo $demanda['idCliente'] ?>">
                                    <input type="text" class="form-control"
                                        value="<?php echo $cliente['nomeCliente'] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Reponsável</label>
                                    <select class="form-control" name="idAtendente">
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                            ?>
                                        <option <?php
                                        if ($atendente['idUsuario'] == $idAtendente) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Ocorrência</label>
                                    <select class="form-control" name="idTipoOcorrencia">
                                        <?php
                                        foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                        <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -14px;">
                                <div class="form-group">
                                    <label class="labelForm">Horas Cobrado</label>
                                    <input type="time" class="data select form-control" name="horaCobrado">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -20px;">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" name="Previsto"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -20px;">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" name="horaInicioPrevisto"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -20px;">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" name="horaFinalPrevisto"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" formaction="../database/tarefas.php?operacao=inserir"
                                class="btn btn-info">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--------- ALTERAR --------->
    <div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" role="dialog"
        aria-labelledby="alterarmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="alterarForm">
                        <div class="row">
                            <div class="col-md-4" style="margin-top: 10px;">
                                <div class="form-group">
                                    <label class="labelForm">Tarefa</label>
                                    <input type="text" class="data select form-control" id="tituloTarefa"
                                        name="tituloTarefa" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -10px;">
                                <div class="form-group" id="demandaContainer">
                                    <label class="labelForm">ID/Demanda Relacionada</label>
                                    <input type="text" class="data select form-control" id="tituloDemanda"
                                        style="margin-top: 18px;" autocomplete="off" readonly>
                                    <select class="form-control" name="idDemandaSelect" id="idDemandaSelect">
                                        <?php
                                        foreach ($demandas as $demanda) {
                                            ?>
                                        <option value="<?php echo $demanda['idDemanda'] ?>"><?php echo $demanda['idDemanda'] . " - " . $demanda['tituloDemanda'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="idTarefa" id="idTarefa" />
                            <input type="hidden" class="form-control" name="idDemanda" id="idDemanda" />
                            <div class="col-md-4" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label class="labelForm">Cliente</label>
                                    <input type="text" class="data select form-control" id="nomeCliente"
                                        style="margin-top: 18px;" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Reponsável</label>
                                    <select class="form-control" name="idAtendente" id="idAtendente">
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                            ?>
                                        <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Ocorrência</label>
                                    <select class="form-control" name="idTipoOcorrencia" id="idTipoOcorrencia">
                                        <?php
                                        foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                        <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                                            <?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -14px;">
                                <div class="form-group">
                                    <label class="labelForm">Horas Cobrado</label>
                                    <input type="time" class="data select form-control" id="horaCobrado"
                                        name="horaCobrado" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" id="Previsto" name="Previsto"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" id="horaInicioPrevisto"
                                        name="horaInicioPrevisto" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" id="horaFinalPrevisto"
                                        name="horaFinalPrevisto" autocomplete="off">
                                </div>
                            </div>
                            <input type="date" class="data select form-control" id="dataReal" name="dataReal"
                                autocomplete="off" hidden>
                            <input type="time" class="data select form-control" id="horaInicioReal"
                                name="horaInicioReal" autocomplete="off" hidden>
                            <input type="time" class="data select form-control" id="horaFinalReal" name="horaFinalReal"
                                autocomplete="off" hidden>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" formaction="../database/tarefas.php?operacao=alterar"
                                class="btn btn-info">Atualizar</button>
                        </div>
                    </form>
                </div>
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