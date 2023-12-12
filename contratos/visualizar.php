<?php
// Lucas 25102023 id643 revisao geral
// Lucas 13102023 novo padrao
include_once '../header.php';
include_once '../database/contratos.php';
include '../database/contratotipos.php';

$idContrato = $_GET['idContrato'];
$contrato = buscaContratos($idContrato, null);
$contratoTipo = buscaContratoTipos($contrato['idContratoTipo']);


include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once '../database/contratos.php';
include_once(ROOT . '/cadastros/database/servicos.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');

/* $urlContratoTipo = $_GET["tipo"];
$contratoTipo = buscaContratoTipos($urlContratoTipo); */

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
    $ClienteSession = $_SESSION['idCliente'];
}

$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$clientes = buscaClientes();
//$contratos = buscaContratosAbertos();
$servicos = buscaServicos();
$atendentes = buscaAtendente();
// Lucas 25102023 id643 ajustado variavel $tipoocorrencias para ficar igual de demanda
$tipoocorrencias = buscaTipoOcorrencia();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
</head>

<body>
    <div class="container-fluid p-0 m-0">
        <div class="row p-0 m-0">
            <!-- <div class="d-flex justify-content-between"> -->
            <div class="col-12 col-md-9 ">
                <form action="../database/contratos.php?operacao=alterar" method="post">
                    <div class="row mt-1">
                        <div class="col-md-9 d-flex align-items-center">
                            <!--     <h2 class="ts-tituloPrincipal"><?php echo $contrato['idContrato'] ?> -
                                <?php echo $contrato['tituloContrato'] ?></h2> -->
                            <span class="ts-tituloPrincipalModal"><?php echo $contrato['idContrato'] ?></span>
                            <input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>">
                            <input type="text" class="form-control ts-tituloPrincipalModal border-0" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>" style="z-index: 1;">
                            <input type="hidden" class="form-control ts-input" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $contrato['idCliente'] ?>" readonly>
                            <span class="ts-subTitulo"><strong>Cliente : </strong> <?php echo $contrato['nomeCliente'] ?></span>

                        </div>

                    </div>
                    <div class="row mt-3">
                        <div id="ts-tabs">
                            <div class="tab whiteborder" id="tab-contrato"><?php echo $contratoTipo['nomeContrato'] ?></div>
                            <div class="tab" id="tab-demandasontrato"><?php echo $contratoTipo['nomeDemanda'] ?></div>
                            <div class="tab" id="tab-notascontrato">Notas</div>
                        </div>
                        <div id="ts-tabs">
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

            </div>
            <div class="col-12 col-md-3 border-start" style="height: 100vh;box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1);">
                <div class="text-end pt-2">
                    <a href="javascript:history.back()" role="button" class="btn btn-primary">
                        <i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                </div>
                <br>
                <br>
                <div class="row mt-4">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Status</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-select ts-input" name="idContratoStatus" autocomplete="off">
                            <option value="<?php echo $contrato['idContratoStatus'] ?>"><?php echo $contrato['nomeContratoStatus'] ?></option>
                            <?php
                            foreach ($contratoStatusTodos as $contratoStatus) {
                            ?>
                                <option value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Abertura</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control ts-input border-0" name="dataAbertura" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataAbertura'])) ?>" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Previsao</label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control ts-input border-0" name="dataPrevisao" value="<?php echo $contrato['dataPrevisao'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Entrega</label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control ts-input border-0" name="dataEntrega" value="<?php echo $contrato['dataEntrega'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Fechamento</label>
                    </div>
                    <div class="col-md-7">
                        <?php if ($contrato['dataFechamento'] == null) { ?>
                            <input type="text" class="form-control ts-input border-0" name="dataFechamento" value="<?php echo $contrato['dataFechamento'] = '00/00/0000 00:00' ?>" disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control ts-input border-0" name="dataFechamento" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataFechamento'])) ?>" disabled>
                        <?php } ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Horas</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-input border-0" name="horas" value="<?php echo $contrato['horas'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Valor Hora</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-input border-0" name="valorHora" value="<?php echo $contrato['valorHora'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Valor Contrato</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-input border-0" name="valorContrato" value="<?php echo $contrato['valorContrato'] ?>">
                    </div>
                </div>

                <hr class="mt-4">

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
            </div>
            </form>
            <!-- /div> -->
        </div>

    </div>


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
            if (id === 'demandacontrato') {
                showTabsContent(1);
            }
            if (id === 'notascontrato') {
                showTabsContent(2);
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

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>