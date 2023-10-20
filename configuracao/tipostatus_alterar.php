<?php
// Lucas 17102023 novo padrao
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../header.php');
include_once '../database/tipostatus.php';

$idTipoStatus = $_GET['idTipoStatus'];

$status = buscaTipoStatus(null, $idTipoStatus);

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body class="bg-transparent">

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
                <h2 class="ts-tituloPrincipal">Alterar Status</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="../configuracao/?tab=configuracao&stab=tipostatus" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/tipostatus.php?operacao=alterar" method="post">

            <div class="col-md-12 mt-3">
                <label class='form-label ts-label'></label>
                <input type="text" class="form-control ts-input" name="nomeTipoStatus" value="<?php echo $status['nomeTipoStatus'] ?>">
                <input type="hidden" class="form-control ts-input" name="idTipoStatus" value="<?php echo $status['idTipoStatus'] ?>">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label ts-label">Atendimento(0=Atendente 1=Cliente)</label>
                        <select class="form-select ts-input" name="mudaPosicaoPara">
                            <option value="<?php echo $status['mudaPosicaoPara'] ?>"><?php echo $status['mudaPosicaoPara'] ?></option>
                            <option>0</option>
                            <option>1</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label ts-label">Situação (0=Fechado 1=Aberto)</label>
                        <select class="form-select ts-input" name="mudaStatusPara">
                            <option value="<?php echo $status['mudaStatusPara'] ?>"><?php echo $status['mudaStatusPara'] ?></option>
                            <option>0</option>
                            <option>1</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-end mt-2">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>