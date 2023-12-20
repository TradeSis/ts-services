<?php
//Lucas 20122023 - iniciado

include_once '../header.php';
include_once '../database/demanda.php';
include_once '../database/contratos.php';
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
    //$horas = buscaHoras($idDemanda);
    $comentarios = buscaComentarios($idDemanda);
}

$servicos = buscaServicos();
$idTipoStatus = $demanda['idTipoStatus'];
//$atendentes = buscaAtendente();
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$cliente = buscaClientes($demanda["idCliente"]);
$clientes = buscaClientes();
$contratos = buscaContratosAbertos($demanda["idCliente"]);



if ($demanda['dataFechamento'] == null) {
    $dataFechamento =  'dd/mm/aaaa';
} else {
    $dataFechamento = date('d/m/Y H:i', strtotime($demanda['dataFechamento']));
}
$statusEncerrar = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_PAUSADO,
    TIPOSTATUS_RETORNO,
    TIPOSTATUS_RESPONDIDO,
    TIPOSTATUS_AGENDADO
);

?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">

        <!-- Modal -->
        <div class="modal" id="modalDemandaVizualizar" tabindex="-1" aria-hidden="true" style="margin: 5px;">
            <div class="col-12 col-md-3 float-end ts-divLateralModalDemanda">
                <div class="col ">
                    <form id="my-form" action="../database/visaocli.php?operacao=demandacli" method="post">
                        <div class="modal-header p-2 pe-3 border-start">
                            <div class="col-md-6 d-flex pt-1">
                                <label class='form-label ts-label'>Prioridade</label>
                                <input type="number" min="1" max="99" class="form-control ts-inputSemBorda border-bottom" name="prioridade" value="<?php echo $demanda['prioridade'] ?>">
                            </div>
                            <div class="col-md-2 border-start d-flex me-2">
                                <a href="index.php" role="button" class="btn-close"></a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Responsável:</label>
                            </div>
                            <div class="col-md-7">
                                <!-- <input type="text" class="form-control ts-inputSemBorda" name="idAtendente" value="<?php echo $demanda['nomeAtendente'] ?>" readonly>
                                <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $demanda['idCliente'] ?>"> -->
                                <span><?php echo $demanda['nomeAtendente'] ?></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Data de Abertura:</label>
                            </div>
                            <div class="col-md-7">
                                <!-- <input type="text" class="form-control ts-inputSemBorda" name="dataabertura" value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly> -->
                                <span><?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?></span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Inicio Previsto</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control ts-inputSemBorda" name="dataPrevisaoInicio" value="<?php echo $demanda['dataPrevisaoInicio'] ?>">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Inicio</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control ts-inputSemBorda" value="<?php echo $demanda['dataInicio'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Entrega Prevista</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control ts-inputSemBorda" name="dataPrevisaoEntrega" value="<?php echo $demanda['dataPrevisaoEntrega'] ?>">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Entrega</label>
                            </div>
                            <div class="col-md-7">
                                <input type="datetime" class="form-control ts-inputSemBorda" name="dataFechamento" value="<?php echo $dataFechamento ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Previsão</label>
                            </div>
                            <div class="col-md-7">
                                <input type="time" class="form-control ts-inputSemBorda" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5 ps-3">
                                <label class="form-label ts-label">Cobrado</label>
                            </div>
                            <div class="col-md-7">
                                <input type="time" class="form-control ts-inputSemBorda" name="tempoCobrado" value="<?php echo $demanda['tempoCobrado'] ?>">
                            </div>
                        </div>


                        <div class="modal-footer">
                            <?php
                            if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO) { ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#encerrarModal" class="btn btn-sm btn-danger">Encerrar</button>
                            <?php }
                            if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO || $demanda['idTipoStatus'] == TIPOSTATUS_VALIDADO) { ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#reabrirModal" class="btn btn-sm btn-warning">Reabrir</button>
                            <?php } ?>

                            <?php if (in_array($demanda['idTipoStatus'], $statusEncerrar)) { ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#entregarModal" class="btn btn-sm btn-warning">Entregar</button>
                            <?php } ?>

                        </div>

                        <div class="modal-footer">
                            <div class="col align-self-start pl-0">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#encaminharModal" class="btn btn-warning">Encaminhar</button>
                            </div>
                            <button type="submit" form="my-form" class="btn btn-success">Atualizar</button>
                        </div>
                </div>
            </div>

            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"> <!-- Modal 1 -->
                <div class="modal-content" style="background-color: #F1F2F4;">
                
                    <div class="container">
                        <?php if (isset($demanda['tituloContrato'])) { ?>
                            <div class="row pb-1">
                                <span class="ts-subTitulo"><strong><?php echo $demanda['nomeContrato'] ?>: </strong> <?php echo $demanda['tituloContrato'] ?></span>
                            </div>
                        <?php } ?>
                        <div class="row g-3">
                            <div class="col-md-9 d-flex">
                                <span class="ts-tituloPrincipalModal"><?php echo $demanda['idDemanda'] ?></span>
                                <input type="hidden" class="form-control ts-inputSemBorda" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
                                <span class="ms-3 ts-tituloPrincipalModal"><?php echo $demanda['tituloDemanda'] ?></span>
                            </div>
                            <div class="col-md-3 d-flex">
                                <span class="ts-subTitulo"><strong>Status: </strong> <?php echo $demanda['nomeTipoStatus'] ?></span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $demanda['idCliente'] ?>">
                                <span class="ts-subTitulo"><strong>Cliente : </strong><span><?php echo $demanda['nomeCliente'] ?></span>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" class="form-control ts-input" name="idSolicitante" id="idSolicitante" value="<?php echo $demanda['idSolicitante'] ?>" readonly>
                                <span class="ts-subTitulo"><strong>Solicitante : </strong> <?php echo $demanda['nomeSolicitante'] ?></span>
                            </div>

                            <div class="col-md-5 d-flex">
                                <input type="hidden" class="form-control ts-input" name="idServico" id="idServico" value="<?php echo $demanda['idServico'] ?>" readonly>
                                <span class="ts-subTitulo"><strong>Serviço : </strong> <?php echo $demanda['nomeServico'] ?></span>
                            </div>
                        </div>
                    </div>

                    </form>

                    <div class="row mt-1">
                        <div id="ts-tabs">
                            <!-- <div class="tab whiteborder" id="tab-demanda">Demanda</div> -->
                            <div class="line"></div>
                        </div>
                    </div>
                    <div class="modal-body">

                        <div id="ts-tabs">
                            <div class="tabContent" style="margin-top: -10px;">
                                <?php include_once '../demandas/demanda_descricao.php'; ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div><!-- Modal 1 -->


        </div>

        <!--------- MODAL ENCERRAR --------->
        <?php include_once '../demandas/modalstatus_encerrar.php' ?>

        <!--------- MODAL REABRIR --------->
        <?php include_once '../demandas/modalstatus_reabrir.php' ?>

        <!--------- MODAL ENCAMINHAR --------->
        <?php include_once '../demandas/modalstatus_encaminhar.php' ?>

        <!--------- MODAL ENTREGAR --------->
        <?php include_once '../demandas/modalstatus_entregar.php' ?>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById("modalDemandaVizualizar"), {});
        document.onreadystatechange = function() {
            myModal.show();
        };

        function refreshPage(tab, idDemanda) {
            window.location.reload();
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab + '&&idDemanda=' + idDemanda;
            window.location.href = newUrl;
        }


        var quilldescricao = new Quill('.quill-textarea', {
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
            },
            scrollingContainer: '#scrolling-container'
        });

        quilldescricao.on('text-change', function(delta, oldDelta, source) {
            $('#quill-descricao').val(quilldescricao.container.firstChild.innerHTML);
        });
    </script>

</body>

</html>