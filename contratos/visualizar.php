<?php
// Lucas 13102023 novo padrao
include_once '../header.php';
include_once '../database/contratos.php';
include '../database/contratotipos.php';

$idContrato = $_GET['idContrato'];
$contrato = buscaContratos($idContrato, null);
$contratoTipo = buscaContratoTipos($contrato['idContratoTipo']);

// LEMBRAR DE AJUSTAR A CLASSE DO EDITOR CSS DO CONTAINER 

include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/clientes.php');
/* include '../database/contratotipos.php'; */
include_once '../database/contratos.php';
include_once(ROOT . '/cadastros/database/servicos.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once '../database/tipoocorrencia.php';

/* $urlContratoTipo = $_GET["tipo"];
$contratoTipo = buscaContratoTipos($urlContratoTipo); */

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
    $ClienteSession = $_SESSION['idCliente'];
}

$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$clientes = buscaClientes();
$contratos = buscaContratosAbertos();
$servicos = buscaServicos();
$atendentes = buscaAtendente();
$ocorrencias = buscaTipoOcorrencia();
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

    .modal_lg {
        margin-left: 10vw;
        margin-top: 0px;
    }

    .containermodal_lg {
        width: 80vw;
        height: 85vh;
    }
</style>

<body>
    <div class="container-fluid">

    <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal"><?php echo $contrato['idContrato'] ?> - 
                <?php echo $contrato['tituloContrato'] ?></h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
            <a href="javascript:history.back()" role="button" class="btn btn-primary">
                <i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <div id="tabs">
            <div class="tab whiteborder" id="tab-contrato"><?php echo $contratoTipo['nomeContrato'] ?></div>
            <div class="tab" id="tab-demandasontrato"><?php echo $contratoTipo['nomeDemanda'] ?></div>
            <div class="tab" id="tab-notascontrato">Notas</div>

            <div class="line"></div>
            <div class="tabContent">
                <?php include_once 'alterar.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'demandascontrato.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'notascontrato.php'; ?>
            </div>

        </div>
    </div>

    <!--------- INSERIR Demanda de Contrato--------->
    <div class="modal fade bd-example-modal-lg" id="inserirDemandaContratoModal" tabindex="-1" role="dialog" aria-labelledby="inserirDemandaContratoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal_lg">
            <div class="modal-content containermodal_lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir <?php echo $contratoTipo['nomeDemanda'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form1">
                        <div class="row">
                            <div class="col-md form-group" style="margin-top: 5px;">
                                <label class='control-label' for='inputNormal' style="margin-top: 4px;"><?php echo $contratoTipo['nomeDemanda'] ?></label>
                                <input type="text" class="form-control" name="tituloDemanda" autocomplete="off" required>
                                <input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
                                <input type="hidden" class="form-control" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>" readonly>
                            </div>
                            <div class="col-md-2 form-group-select" style="margin-top: -20px;">
                                <div class="form-group">
                                    <label class="labelForm">Cliente</label>
                                    <select class="select form-control" name="idCliente" autocomplete="off" disabled>
                                        <option value="<?php echo $contrato['idCliente'] ?>"><?php echo $contrato['nomeCliente'] ?>
                                        </option>
                                        <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?>
                                        </option>
                                    </select>
                                    <input type="hidden" class="form-control" name="idCliente" value="<?php echo $cliente['idCliente'] ?>" readonly>
                                    <input type="hidden" class="form-control" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>

                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 5px;">
                            <div class="col-md-6">
                                <div class="container-fluid p-0">
                                    <div class="col">
                                        <span class="tituloEditor">Descrição</span>
                                    </div>
                                    <div class="quill-demandainserir" style="height:20vh !important"></div>
                                    <textarea style="display: none" id="quill-demandainserir" name="descricao"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 25px;">
                                <div class="row">
                                    <div class="col-md-6 form-group" style="margin-top: -25px;">
                                        <label class="labelForm">Previsão</label>
                                        <input type="number" class="data select form-control" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
                                    </div>
                                    <div class="col-md-6 form-group-select" style="margin-top: -25px;">
                                        <label class="labelForm">Ocorrência</label>
                                        <select class="select form-control" name="idTipoOcorrencia" autocomplete="off">
                                            <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                            <?php
                                            foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                                <option <?php
                                                        if ($ocorrencia['ocorrenciaInicial'] == 1) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div><!--fim row 1-->

                                <div class="row">
                                    <div class="col-md-6 form-group-select" style="margin-top: -25px;">
                                        <label class="labelForm">Tamanho</label>
                                        <select class="select form-control" name="tamanho">
                                            <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                            <option value="P">P</option>
                                            <option value="M">M</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group-select" style="margin-top: -25px; ">
                                        <label class="labelForm">Serviço</label>
                                        <select class="select form-control" name="idServico" autocomplete="off">
                                            <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                            <?php foreach ($servicos as $servico) { ?>
                                                <option value="<?php echo $servico['idServico'] ?>"><?php echo $servico['nomeServico'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><!--fim row 2-->

                                <div class="row">
                                    <div class="col-md-6 form-group-select" style="margin-top: 40px;">
                                        <label class="labelForm">Responsável</label>
                                        <select class="select form-control" name="idAtendente">
                                            <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                            <?php foreach ($atendentes as $atendente) { ?>
                                                <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group-select" style="margin-top: 40px;">
                                        <label class="labelForm">Contrato Vinculado</label>
                                        <?php if ($contratoTipo['idContratoTipo'] == 'os') { ?>
                                            <select class="select form-control" name="idContrato" autocomplete="off" required>
                                            <?php } else { ?>
                                                <select class="select form-control" name="idContrato" autocomplete="off" disabled>
                                                <?php } ?>
                                                <option value="<?php echo $contrato['idContrato'] ?>"><?php echo $contrato['tituloContrato'] ?></option>
                                                </select>
                                    </div>
                                </div><!--fim row 3-->
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" formaction="../database/demanda.php?operacao=inserir_demandadecontrato" class="btn btn-success">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--------- MODAL INSERIR NOTAS --------->
    <div class="modal fade bd-example-modal-lg" id="inserirModalNotas" tabindex="-1" role="dialog" aria-labelledby="inserirModalNotasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container-fluid">
                    <form method="post" id="inserirFormNotaContrato">
                        <div class="row">
                            <div class="col-md-6 form-group-select">
                                <div class="form-group">
                                    <label class="labelForm">Cliente</label>
                                    <input type="text" class="data select form-control" name="nomeCliente" value="<?php echo $contrato['nomeCliente'] ?>" disabled>
                                    <input type="hidden" class="form-control" name="idCliente" value="<?php echo $contrato['idCliente'] ?>" readonly>
                                    <input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm' style="margin-top: -5px;">dataFaturamento</label>
                                <input type="date" class="form-control" name="dataFaturamento" autocomplete="off" required style="margin-top: -5px;">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm' style="margin-top: -5px;">dataEmissao</label>
                                <input type="date" class="form-control" name="dataEmissao" autocomplete="off" style="margin-top: -5px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class='labelForm' style="margin-top: -5px;">serieNota</label>
                                <input type="text" class="form-control" name="serieNota" autocomplete="off" style="margin-top: -5px;">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class='labelForm' style="margin-top: -5px;">numeroNota</label>
                                <input type="text" class="form-control" name="numeroNota" autocomplete="off" style="margin-top: -5px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class='labelForm' style="margin-top: -5px;">serieRPS</label>
                                <input type="text" class="form-control" name="serieRPS" autocomplete="off" style="margin-top: -5px;">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm' style="margin-top: -5px;">numeroRPS</label>
                                <input type="text" class="form-control" name="numeroRPS" autocomplete="off" style="margin-top: -5px;">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm' style="margin-top: -5px;">valorNota</label>
                                <input type="text" class="form-control" name="valorNota" autocomplete="off" value="<?php echo $contrato['valorContrato'] ?>" required style="margin-top: -5px;">
                            </div>
                            <div class="col-md-3 form-group-select">
                                <div class="form-group">
                                    <label class="labelForm">statusNota</label>
                                    <select class="select form-control" name="statusNota" autocomplete="off" required style="margin-top: -5px;">
                                        <option value="0">Aberto</option>
                                        <option value="1">Emitida</option>
                                        <option value="2">Recebida</option>
                                        <option value="3">Cancelada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class='labelForm' style="margin-top: -5px;">condicao</label>
                                <input type="text" class="form-control" name="condicao" autocomplete="off" style="margin-top: -5px;">
                            </div>
                        </div>

                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--------- MODAL ALTERAR NOTAS --------->
    <div class="modal fade bd-example-modal-lg" id="alterarModalNotas" tabindex="-1" role="dialog" aria-labelledby="alterarModalNotasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="alterarFormNotaContrato">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="labelForm">idNotaServico</label>
                                    <input type="text" class="data select form-control" id="idNotaServico" name="idNotaServico" readonly>
                                    <input type="hidden" class="data select form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Cliente</label>
                                    <input type="text" class="data select form-control" name="nomeCliente" id="nomeCliente" disabled>
                                    <input type="hidden" class="data select form-control" name="idCliente" id="idCliente" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm'>dataFaturamento</label>
                                <input type="date" class="data select form-control" name="dataFaturamento" id="dataFaturamento" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm'>dataEmissao</label>
                                <input type="date" class="data select form-control" name="dataEmissao" id="dataEmissao">
                            </div>
                        </div>
                        <div class="row" style="margin-top: -55px;">
                            <div class="col-md-6 form-group">
                                <label class='labelForm'>serieNota</label>
                                <input type="text" class="data select form-control" name="serieNota" id="serieNota">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class='labelForm'>numeroNota</label>
                                <input type="text" class="data select form-control" name="numeroNota" id="numeroNotabd">
                            </div>
                        </div>
                        <div class="row" style="margin-top: -55px;">
                            <div class="col-md-3 form-group">
                                <label class='labelForm'>serieRPS</label>
                                <input type="text" class="data select form-control" name="serieRPS" id="serieRPS">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm'>numeroRPS</label>
                                <input type="text" class="data select form-control" name="numeroRPS" id="numeroRPS">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class='labelForm'>valorNota</label>
                                <input type="text" class="data select form-control" name="valorNota" id="valorNota" required>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class='labelForm'>statusNota</label>
                                <input type="text" class="data select form-control" name="statusNota" id="statusNota" required>
                            </div>

                        </div>
                        <div class="row" style="margin-top: -55px;">
                            <div class="col-md-12 form-group">
                                <label class='labelForm'>condicao</label>
                                <input type="text" class="data select form-control" name="condicao" id="condicao">
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        var tab;
        var tabContent;

        window.onload = function() {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'demandacontrato') {
                showTabsContent(1);
            }
            if (id === 'notascontrato') {
                showTabsContent(2);
            }
        }

        document.getElementById('tabs').onclick = function(event) {
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
        var demandaContrato = new Quill('.quill-demandainserir', {
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
                    /*  [{
                       'header': [1, 2, 3, 4, 5, 6, false]
                     }], */
                    ['link', 'image'],
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

        demandaContrato.on('text-change', function(delta, oldDelta, source) {
            $('#quill-demandainserir').val(demandaContrato.container.firstChild.innerHTML);
        });
    </script>
</body>

</html>