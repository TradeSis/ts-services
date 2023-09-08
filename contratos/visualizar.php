<?php

include_once '../head.php';
include_once '../database/contratos.php';
include '../database/contratotipos.php';

$idContrato = $_GET['idContrato'];
$contrato = buscaContratos($idContrato, null);
$contratoTipo = buscaContratoTipos($contrato['idContratoTipo']);

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
                <span class="titulo">
                <?php echo $contrato['tituloContrato'] ?>
                </span>
            </div>
            <div class="col-sm mt-3" style="text-align:right;margin-right:50px;">
                <a href="javascript:history.back()" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>
        <div id="tabs">
            <div class="tab whiteborder" id="tab-contrato"><?php echo $contratoTipo['nomeContrato'] ?></div>
            <div class="tab" id="tab-demandacontrato"><?php echo $contratoTipo['nomeDemanda'] ?></div>
           
            <div class="line"></div>
            <div class="tabContent">
                <?php include_once 'alterar.php'; ?>
            </div>
            <div class="tabContent">
                <?php include_once 'demandaContrato.php'; ?>
            </div>
         
        </div>
    </div>

    <!--------- INSERIR --------->
    <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" role="dialog"
        aria-labelledby="inserirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir <?php echo $contratoTipo['nomeDemanda'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="form1">
                    <div class="row">
									<div class="col-md form-group" style="margin-top: 25px;">
										<label class='control-label' for='inputNormal' style="margin-top: 4px;">Demanda</label>
										<input type="text" class="form-control" name="tituloDemanda" autocomplete="off" required>
										<input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
										<input type="hidden" class="form-control" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>" readonly>
									</div>
									<div class="col-md-2 form-group-select">
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
								<div class="row">
									<div class="col form-group">
										<label class="labelForm">Descrição</label>
										<textarea class="form-control" name="descricao" autocomplete="off" rows="10"></textarea>
									</div>
								</div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" formaction="../database/demanda.php?operacao=inserir_demandadecontrato"
                                class="btn btn-info">Salvar</button>
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