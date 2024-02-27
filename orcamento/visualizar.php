<?php
// Lucas 25102023 id643 revisao geral
// Lucas 13102023 novo padrao
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/orcamento.php');
include_once(__DIR__ . '/../database/orcamentoStatus.php');
include_once(__DIR__ . '/../database/contratotipos.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');
$idOrcamento = $_GET['idOrcamento'];
$orcamento = buscaOrcamentos($idOrcamento);
$orcamentoitens = buscaOrcamentoItens($idOrcamento);
$usuario = buscaUsuarios(null, $_SESSION['idLogin']);

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
    $ClienteSession = $_SESSION['idCliente'];
}

$clientes = buscaClientes();
$contratoTipos = buscaContratoTipos();
$orcamentosStatus = buscaOrcamentoStatus();

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body class="ts-fundoVisualizar">
    <div class="container-fluid p-0 m-0">

        <div class="row p-0 m-0">
            <div class="col-12 col-md-9 ">
                <form action="../database/orcamento.php?operacao=alterar" method="post">
                    <div class="row mt-1">
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="ts-tituloPrincipalModal">
                                <?php echo $orcamento['idOrcamento'] ?>
                            </span>
                            <input type="hidden" class="form-control" name="idOrcamento"
                                value="<?php echo $orcamento['idOrcamento'] ?>">
                            <input type="text" class="form-control ts-inputSemBorda ts-tituloPrincipalModal border-0"
                                name="tituloOrcamento" value="<?php echo $orcamento['tituloOrcamento'] ?>"
                                style="z-index: 1;">
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <input type="hidden" class="form-control ts-input" name="idCliente"
                                value="<?php echo $orcamento['idCliente'] ?>" readonly>
                            <span class="ts-subTitulo"><strong>Cliente : </strong>
                                <?php echo $orcamento['nomeCliente'] ?>
                            </span>

                        </div>

                    </div>
                    <div class="row mt-3">
                        <div id="ts-tabs">
                            <div class="tab aba1 whiteborder" id="tab-orcamento">Orçamento</div>
                            <div class="tab aba2" id="tab-itens">Itens</div>
                        </div>
                        <div id="ts-tabs">
                            <div class="line"></div>
                            <div class="tabContent aba1_conteudo">
                                <div class="container-fluid p-0 mt-3">
                                    <div class="col">
                                        <span class="tituloEditor">Descrição</span>
                                    </div>
                                    <div class="quill-orcamentoDescricao bg-white" style="height:300px!important">
                                        <?php echo $orcamento['descricao'] ?>
                                    </div>
                                    <textarea style="display: none" id="quill-orcamentoDescricao"
                                        name="descricao"><?php echo $orcamento['descricao'] ?></textarea>
                                </div>
                            </div>
                            <div class="tabContent aba2_conteudo" style="display: none;">
                                <?php include_once 'orcamentoitens.php'; ?>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="col-12 col-md-3"
                style="height: 100vh;box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1);">
                <div class="modal-header p-2 pe-3">
                    <div class="col-md-6 d-flex pt-1">
                    </div>
                    <div class="col-md-2 border-start d-flex me-2">
                        <a href="../orcamento/" role="button" class="btn-close"></a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Status</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-select ts-input ts-selectDemandaModalVisualizar" name="idOrcamentoStatus"
                            autocomplete="off">
                            <?php
                            foreach ($orcamentosStatus as $orcamentoStatus) {
                                ?>
                                <option <?php
                                if ($orcamentoStatus['idOrcamentoStatus'] == $orcamento['idOrcamentoStatus']) {
                                    echo "selected";
                                }
                                ?> value="<?php echo $orcamentoStatus['idOrcamentoStatus'] ?>">
                                    <?php echo $orcamentoStatus['nomeOrcamentoStatus'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Cliente</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-select ts-input ts-selectDemandaModalVisualizar" name="idCliente"
                            autocomplete="off">
                            <?php
                            foreach ($clientes as $cliente) {
                                ?>
                                <option <?php
                                if ($cliente['idCliente'] == $orcamento['idCliente']) {
                                    echo "selected";
                                }
                                ?> value="<?php echo $cliente['idCliente'] ?>">
                                    <?php echo $cliente['nomeCliente'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Abertura</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control ts-inputSemBorda" name="dataAbertura"
                            value="<?php echo date('d/m/Y H:i', strtotime($orcamento['dataAbertura'])) ?>" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Aprovação</label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control ts-inputSemBorda" name="dataAprovacao"
                            value="<?php echo $orcamento['dataAprovacao'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Horas</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-inputSemBorda" name="horas"
                            value="<?php echo $orcamento['horas'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Valor Hora</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-inputSemBorda" name="valorHora"
                            value="<?php echo $orcamento['valorHora'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Valor Orcamento</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-inputSemBorda" name="valorOrcamento"
                            value="<?php echo $orcamento['valorOrcamento'] ?>">
                    </div>
                </div>

                <hr class="mt-4">

                <div class="modal-footer">
                    <?php if ($orcamento['idOrcamentoStatus'] == 2) {  //Aprovado ?>
                        <div class="col align-self-start pl-0">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#gerarContratoModal"
                                class="btn btn-warning">Gerar Contrato</button>
                        </div>
                    <?php } ?>
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
            </div>
            </form>
        </div>

        <!--------- MODAL ORCAMENTO ITENS ALTERAR --------->
        <?php include_once 'modalOrcamentoItens_alterar.php' ?>

        <!--------- MODAL ORCAMENTO ITENS INSERIR --------->
        <?php include_once 'modalOrcamentoItens_inserir.php' ?>

        <!--------- MODAL ORCAMENTO ITENS EXCLUIR --------->
        <?php include_once 'modalOrcamentoItens_excluir.php' ?>

        <!--------- MODAL GERAR CONTRATO --------->
        <?php include_once 'modalGerarContrato.php' ?>



    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script src="orcamento.js"></script>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


    <!-- Gabriel 201223 id745 include de modalNotaOrcamento -->


</body>

</html>