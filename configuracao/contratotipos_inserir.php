<?php
// Lucas 17102023 novo padrao
include_once('../header.php');
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

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
                <h2 class="ts-tituloPrincipal">Contrato Tipos</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="../configuracao/?tab=configuracao&stab=contratotipos" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>


        <form class="mb-4" action="../database/contratotipos.php?operacao=inserir" method="post">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class='control-label' for='inputNormal' style="margin-top: -5px;">Nome</label>
                    <div class="for-group">
                        <input type="text" name="idContratoTipo" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label class='control-label' for='inputNormal' style="margin-top: -5px;">Nome Contrato</label>
                    <div class="for-group">
                        <input type="text" name="nomeContrato" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label class='control-label' for='inputNormal' style="margin-top: -5px;">Nome Demanda</label>
                    <div class="for-group">
                        <input type="text" name="nomeDemanda" class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>