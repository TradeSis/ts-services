<?php
// Lucas 25102023 id643 revisao geral
// Lucas 13102023 novo padrao
include_once '../header.php';
include_once '../database/contratos.php';
include '../database/contratotipos.php';
include_once '../database/demanda.php';
include_once '../database/contratochecklist.php';
$idContrato = $_GET['idContrato'];
$contrato = buscaContratos($idContrato, null);
$contratoTipo = buscaContratoTipos($contrato['idContratoTipo']);


include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once '../database/contratos.php';
include_once(ROOT . '/cadastros/database/servicos.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
include_once '../database/contratoStatus.php';
include_once '../database/tarefas.php';
// Gabriel 201223 id745 dados nota
include_once(ROOT . '/cadastros/database/pessoas.php');

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
    $ClienteSession = $_SESSION['idCliente'];
}

$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$clientes = buscaClientes();
$servicos = buscaServicos();
$atendentes = buscaAtendente();
// Gabriel 201223 id745 dados nota
$pessoas = buscarPessoa();
$cidades = buscarCidades();
// Lucas 25102023 id643 ajustado variavel $tipoocorrencias para ficar igual de demanda
$tipoocorrencias = buscaTipoOcorrencia();
$contratoStatusTodos = buscaContratoStatus();

$contratoschecklist = buscaChecklist($idContrato);
$demandas = buscaDemandas(null, null, $idContrato);
$horasCobrado = buscaTotalHorasCobrada($idContrato);
$horasReal = buscaTotalHorasReal($idContrato, null);
//Remover os zeros de segundo de totalHorasCobrado
if ($horasCobrado['totalHorasCobrado'] !== null) {
    $totalHorasCobrado = $horasCobrado['totalHorasCobrado'];
} else {
    $totalHorasCobrado = "00:00";
}
//Remover os zeros de segundo de totalHorasReal
if ($horasReal['totalHorasReal'] !== null) {
    $totalHorasRealizado = $horasReal['totalHorasReal']; 
} else {
    $totalHorasRealizado = "00:00";
}
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
                <form action="../database/contratos.php?operacao=alterar" method="post">
                    <div class="row mt-1">
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="ts-tituloPrincipalModal"><?php echo $contrato['idContrato'] ?></span>
                            <input type="hidden" class="form-control" name="idContrato" value="<?php echo $contrato['idContrato'] ?>">
                            <input type="text" class="form-control ts-inputSemBorda ts-tituloPrincipalModal border-0" name="tituloContrato" value="<?php echo $contrato['tituloContrato'] ?>" style="z-index: 1;">
                            <input type="hidden" class="form-control ts-input" name="idContratoTipo" value="<?php echo $contrato['idContratoTipo'] ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $contrato['idCliente'] ?>" readonly>
                            <span class="ts-subTitulo"><strong>Cliente : </strong> <?php echo $contrato['nomeCliente'] ?></span>

                        </div>

                    </div>
                    <div class="row mt-3">
                        <div id="ts-tabs">
                            <div class="tab aba1 whiteborder" id="tab-contrato"><?php echo $contratoTipo['nomeContrato'] ?></div>
                            <div class="tab aba2" id="tab-demandasontrato"><?php echo $contratoTipo['nomeDemanda'] ?></div>
                            <div class="tab aba3" id="tab-contratochecklist">Checklist</div>
                            <div class="tab aba4" id="tab-notascontrato">Notas</div>
                        </div>
                        <div id="ts-tabs">
                            <div class="line"></div>
                            <div class="tabContent aba1_conteudo">
                                <div class="container-fluid p-0 mt-3">
                                    <div class="col">
                                        <span class="tituloEditor">Descrição</span>
                                    </div>
                                    <div class="quill-contratoDescricao bg-white" style="height:300px!important"><?php echo $contrato['descricao'] ?></div>
                                    <textarea style="display: none" id="quill-contratoDescricao" name="descricao"><?php echo $contrato['descricao'] ?></textarea>
                                </div>
                            </div>
                            <div class="tabContent aba2_conteudo" style="display: none;">
                                <?php include_once 'demandascontrato.php'; ?>
                            </div>
                            <div class="tabContent aba3_conteudo" style="display: none;">
                                <?php include_once 'contratochecklist.php'; ?>
                            </div>
                            <div class="tabContent aba4_conteudo" style="display: none;">
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
                        <select class="form-select ts-input ts-selectDemandaModalVisualizar" name="idContratoStatus" autocomplete="off">
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
                        <input type="text" class="form-control ts-inputSemBorda" name="dataAbertura" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataAbertura'])) ?>" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Previsao</label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control ts-inputSemBorda" name="dataPrevisao" value="<?php echo $contrato['dataPrevisao'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Entrega</label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control ts-inputSemBorda" name="dataEntrega" value="<?php echo $contrato['dataEntrega'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Fechamento</label>
                    </div>
                    <div class="col-md-7">
                        <?php if ($contrato['dataFechamento'] == null) { ?>
                            <input type="text" class="form-control ts-inputSemBorda" name="dataFechamento" value="<?php echo $contrato['dataFechamento'] = '00/00/0000 00:00' ?>" disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control ts-inputSemBorda" name="dataFechamento" value="<?php echo date('d/m/Y H:i', strtotime($contrato['dataFechamento'])) ?>" disabled>
                        <?php } ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Horas</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-inputSemBorda" name="horas" value="<?php echo $contrato['horas'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Valor Hora</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-inputSemBorda" name="valorHora" value="<?php echo $contrato['valorHora'] ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Valor Contrato</label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control ts-inputSemBorda" name="valorContrato" value="<?php echo $contrato['valorContrato'] ?>">
                    </div>
                </div>
                <hr>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Total Cobrado:</label>
                    </div>
                    <div class="col-md-7 ps-4">
                        <?php echo $totalHorasCobrado ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5">
                        <label class="form-label ts-label">Total Real:</label>
                    </div>
                    <div class="col-md-7 ps-4">
                        <?php echo $totalHorasRealizado ?>
                    </div>
                </div>

                <hr class="mt-4">

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
            </div>
            </form>
        </div>

        <!-- Lucas 25102023 id643 include de modalDemanda_inserir -->
        <!--------- MODAL DEMANDA INSERIR --------->
        <?php include_once '../demandas/modalDemanda_inserir.php' ?>
        <!--------- MODAL CHECKLIST INSERIR --------->
        <?php include_once '../contratos/modalChecklist_inserir.php' ?>
        <!--------- MODAL CHECKLIST ALTERAR --------->
        <?php include_once '../contratos/modalChecklist_alterar.php' ?>
        <!--------- MODAL CHECKLIST EXCLUIR --------->
        <?php include_once '../contratos/modalChecklist_excluir.php' ?>
        <!--------- MODAL CHECKLIST TAREFA --------->
        <?php include_once '../contratos/modalChecklist_tarefa.php' ?>
        
       

    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script src="contrato.js"></script>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


    <!-- Gabriel 201223 id745 include de modalNotaContrato -->
    <!--------- MODAL NOTA CONTRATO VISUALIZAR --------->
    <?php include_once '../contratos/modalNotaContrato_visualizar.php' ?>
    <!--------- MODAL NOTA CONTRATO INSERIR --------->
    <?php include_once '../contratos/modalNotaContrato_inserir.php' ?>
    <!--------- MODAL NOTA CONTRATO ALTERAR --------->
    <?php include_once '../contratos/modalNotaContrato_alterar.php' ?>
    
</body>

</html>