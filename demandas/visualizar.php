<?php
//Gabriel 11102023 ID 596 mudanças em agenda e tarefas
//Gabriel 26092023 ID 575 Demandas/Comentarios - Layout de chat
//lucas 25092023 ID 358 Demandas/Comentarios
// Gabriel 22092023 id 544 Demandas - Botão Voltar
//lucas 22092023 ID 358 Demandas/Comentarios 

include_once '../header.php';
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

if ($idDemanda !== "") {
    $tarefas = buscaTarefas($idDemanda);
    $horas = buscaHoras($idDemanda);
    $comentarios = buscaComentarios($idDemanda);
}

$servicos = buscaServicos();
$idTipoStatus = $demanda['idTipoStatus'];
$atendentes = buscaAtendente();
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$cliente = buscaClientes($demanda["idCliente"]);
$clientes = buscaClientes();
$contratos = buscaContratosAbertos($demanda["idCliente"]);

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
    $ClienteSession = $_SESSION['idCliente'];
}

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link rel="stylesheet" href="../css/tabs_visualizar.css">

</head>


<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm mt-3 ml-4" >
                <span class="titulo">
                    <?php echo $idDemanda ?> - <?php echo $demanda['tituloDemanda'] ?>
                </span>
            </div>
         
            <div class="col-sm mt-3 text-end">
                <!-- Gabriel 22092023 id544 href dinâmico com session -->
                <?php if (isset($_SESSION['origem'])) { ?>
                    <a href="<?php echo $_SESSION['origem'] ?>" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                <?php } ?>
            </div>
        </div>
        <div id="ts-tabs">
            <div class="tab whiteborder" id="tab-demanda">Demanda</div>
            <div class="tab" id="tab-comentarios">Comentarios</div>
            <?php if ($ClienteSession == NULL) { ?>
                <div class="tab" id="tab-tarefas">Tarefas</div>
            <?php } ?>
            <div class="tab" id="tab-mensagem">mensagem</div>
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
            <!-- Gabriel 26092023 ID 575 adicionado tab mensagens -->
            <div class="tabContent">
                <?php 
                 /***  helio 24.10.2023 - retirado CHAT, pois estava derrubando oservidor 
                  **  include_once 'mensagem.php'; 
                    **/
                    ?>
            </div>
        </div>
    </div>

    <!--------- INSERIR/NOVA --------->
    <div class="modal" id="inserirModal" tabindex="-1"  aria-labelledby="inserirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form1">
                        <div class="row">
                            <div class="col-md-4">
                                <label class='form-label ts-label'>Tarefa</label>
                                <input type="text" class="form-control ts-input" name="tituloTarefa" autocomplete="off">
                                <input type="hidden" class="form-control ts-input" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>">
                            </div>
                            <div class="col-md-4">
                                <label class='form-label ts-label'>ID/Demanda Relacionada</label>
                                <input type="hidden" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
                                <input type="text" class="form-control ts-input" value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>" readonly>
                                <input type="hidden" name="tipoStatusDemanda" value="<?php echo $idTipoStatus ?>" />
                            </div>
                            <div class="col-md-4">
                                <label class='form-label ts-label'>Cliente</label>
                                <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $demanda['idCliente'] ?>">
                                <input type="text" class="form-control ts-input" value="<?php echo $cliente['nomeCliente'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class='form-label ts-label'>Reponsável</label>
                                <select class="form-select ts-input" name="idAtendente">
                                    <?php
                                    foreach ($atendentes as $atendente) {

                                    ?>
                                        <option <?php
                                                if ($atendente['idUsuario'] == $demanda['idAtendente']) {
                                                    echo "selected";
                                                }
                                                ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class='form-label ts-label'>Ocorrência</label>
                                <select class="form-select ts-input" name="idTipoOcorrencia">
                                    <?php
                                    foreach ($ocorrencias as $ocorrencia) {
                                    ?>
                                        <option <?php
                                                if ($ocorrencia['idTipoOcorrencia'] == $demanda['idTipoOcorrencia']) {
                                                    echo "selected";
                                                } /*lucas 25092023 ID 358 indentado value de idTipoOcorrencia para não passar valor em branco*/  ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label ts-label">Horas Cobrado</label>
                                <input type="time" class="form-control ts-input" name="horaCobrado">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class="form-label ts-label">Data Previsão</label>
                                <input type="date" class="form-control ts-input" name="Previsto" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label ts-label">Inicio</label>
                                <input type="time" class="form-control ts-input" name="horaInicioPrevisto" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label ts-label">Fim</label>
                                <input type="time" class="form-control ts-input" name="horaFinalPrevisto" autocomplete="off">
                            </div>
                        </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="submit" formaction="../database/tarefas.php?operacao=inserirStart" class="btn btn-warning">Start</button>
                    <button type="submit" formaction="../database/tarefas.php?operacao=inserir" class="btn btn-success">Inserir</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <!--Gabriel 11102023 ID 596 removido modal Alterar tarefa -->

    <!--------- MODAL STOP --------->
    <div class="modal" id="stopmodal" tabindex="-1" aria-labelledby="stopmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Comentários</span>
                            </div>
                            <div class="quill-stop" style="height:20vh !important"></div>
                            <textarea style="display: none" id="quill-stop" name="comentario"></textarea>
                        </div>
                        <div class="col-md">
                            <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>

                            <input type="hidden" class="form-control" name="idTarefa" id="idTarefa-stop" />
                            <input type="hidden" class="form-control" name="idDemanda" id="idDemanda-stop" />
                            <input type="hidden" class="form-control" name="tipoStatusDemanda" id="status-stop" />
                            <input type="time" class="form-control" name="horaInicioCobrado" id="horaInicioReal-stop" step="2" readonly style="display: none;" />

                        </div>
                </div>
                <div class="modal-footer">
                    <div class="col align-self-start pl-0">
                        <button type="submit" formaction="../database/demanda.php?operacao=realizado" class="btn btn-warning float-left">Entregar</button>
                    </div>
                    <button type="submit" formaction="../database/tarefas.php?operacao=stop" class="btn btn-danger">Stop</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--------- MODAL ENCERRAR --------->
    <div class="modal" id="encerrarModal" tabindex="-1" role="dialog" aria-labelledby="encerrarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Comentários</span>
                            </div>
                            <!-- lucas 22092023 ID 358 Modificado nome da classe do editor-->
                            <div class="quill-encerrar" style="height:20vh !important"></div>
                            <textarea style="display: none" id="quill-encerrar" name="comentario"></textarea>
                            <!-- -->
                        </div>
                        <div class="col-md">
                            <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                            <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>" readonly>
                        </div>
                </div>
                <div class="modal-footer">
                    <!-- lucas 22092023 ID 358 Modificado nome do botao-->
                    <button type="submit" formaction="../database/demanda.php?operacao=validar" class="btn btn-danger">Encerrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- lucas 22092023 ID 358 Modificado nome da chamada do modal para reabrir-->
    <!--------- MODAL REABRIR --------->
    <div class="modal" id="reabrirModal" tabindex="-1" role="dialog" aria-labelledby="reabrirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Comentários</span>
                            </div>
                            <!-- lucas 22092023 ID 358 Modificado nome da classe do editor-->
                            <div class="quill-reabrir" style="height:20vh !important"></div>
                            <textarea style="display: none" id="quill-reabrir" name="comentario"></textarea>
                            <!-- -->
                        </div>
                        <div class="col-md">
                            <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                            <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>" readonly>
                        </div>
                </div>
                <div class="modal-footer">
                    <!-- lucas 22092023 ID 358 Modificado nome do botao-->
                    <button type="submit" formaction="../database/demanda.php?operacao=retornar" class="btn btn-warning">Reabrir</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--------- MODAL ENCAMINHAR --------->
    <div class="modal" id="encaminharModal" tabindex="-1" role="dialog" aria-labelledby="encaminharModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Comentários</span>
                            </div>
                            <div class="quill-encaminhar" style="height:20vh !important"></div>
                            <textarea style="display: none" id="quill-encaminhar" name="comentario"></textarea>
                        </div>
                        <div class="col-md">
                            <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                            <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>" readonly>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class='form-label ts-label'>Reponsável</label>
                            <select class="form-select ts-input" name="idAtendente">
                                <?php
                                foreach ($atendentes as $atendente) {
                                ?>
                                    <option <?php
                                            if ($atendente['idUsuario'] == $demanda['idAtendente']) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" formaction="../database/demanda.php?operacao=solicitar" class="btn btn-warning">Encaminhar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- lucas 22092023 ID 358 Modificado nome da chamada do modal para entregar-->
    <!--------- MODAL ENTREGAR --------->
    <div class="modal" id="entregarModal" tabindex="-1" role="dialog" aria-labelledby="entregarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Comentários</span>
                            </div>
                            <!-- lucas 22092023 ID 358 Modificado nome da classe do editor-->
                            <div class="quill-entregar" style="height:20vh !important"></div>
                            <textarea style="display: none" id="quill-entregar" name="comentario"></textarea>
                            <!-- -->
                        </div>
                        <div class="col-md">
                            <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                            <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>" readonly>
                        </div>

                </div>
                <div class="modal-footer">
                    <!-- lucas 22092023 ID 358 Modificado nome do botao-->
                    <button type="submit" formaction="../database/demanda.php?operacao=realizado" class="btn btn-warning">Entregar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Gabriel 11102023 ID 596 modal Alterar tarefa via include -->
    <!--Lucas 18102023 ID 602 alterado nome do arquivo para modalTarefa_alterar -->
    <?php include 'modalTarefa_alterar.php'; ?>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var tab;
        var tabContent;

        window.onload = function() {
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
            //Gabriel 26092023 ID 575 adicionado tab mensagens
            if (id === 'mensagem') {
                showTabsContent(3);
            }
        }

        document.getElementById('ts-tabs').onclick = function(event) {
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

    <script>
        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        var quillencerrar = new Quill('.quill-encerrar', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                ]
            }
        });

        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        quillencerrar.on('text-change', function(delta, oldDelta, source) {
            $('#quill-encerrar').val(quillencerrar.container.firstChild.innerHTML);
        });

        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        var quillreabrir = new Quill('.quill-reabrir', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                ]
            }
        });
        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        quillreabrir.on('text-change', function(delta, oldDelta, source) {
            $('#quill-reabrir').val(quillreabrir.container.firstChild.innerHTML);
        });

        var quillencaminhar = new Quill('.quill-encaminhar', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                ]
            }
        });

        quillencaminhar.on('text-change', function(delta, oldDelta, source) {
            $('#quill-encaminhar').val(quillencaminhar.container.firstChild.innerHTML);
        });

        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        var quillentregar = new Quill('.quill-entregar', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                ]
            }
        });

        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        quillentregar.on('text-change', function(delta, oldDelta, source) {
            $('#quill-entregar').val(quillentregar.container.firstChild.innerHTML);
        });

        var quillstop = new Quill('.quill-stop', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                ]
            }
        });

        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        quillstop.on('text-change', function(delta, oldDelta, source) {
            $('#quill-stop').val(quillstop.container.firstChild.innerHTML);
        });
        //Gabriel 11102023 ID 596 script para tratar o envio e retorno do form alterar tarefa
        $(document).ready(function() {
            $("#alterarForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                var vurl;
                if ($("#stopButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=stop";
                }
                if ($("#startButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=start";
                }
                if ($("#realizadoButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=realizado";
                }
                if ($("#atualizarButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=alterar";
                }
                $.ajax({
                    url: vurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage('tarefas', <?php echo $idDemanda ?>)

                });
            });
        });

        function refreshPage(tab, idDemanda) {
            window.location.reload();
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab + '&&idDemanda=' + idDemanda;
            window.location.href = newUrl;
        }
    </script>
</body>

</html>