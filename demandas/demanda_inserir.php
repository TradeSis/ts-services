<?php
// Lucas 10032023 - alterado input value= php echo $logado " para value = ($_SESSION['usuario']). linha 68
// Lucas 10032023 - alterado buscaUsuarios($logado) para buscaUsuarios($_SESSION['idUsuario']), linha 18
// gabriel 06032023 11:25 - removido required da descrição
// gabriel 06022023 - removido prioridade, adiciona usuario trade como responsável padrão
// helio 01022023 alterado para include_once
// gabriel 31012023 13:47 - nomeclaturas
// helio 26012023 16:16


include_once '../head.php';
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include '../database/contratotipos.php';
include_once '../database/contratos.php';
include_once(ROOT . '/cadastros/database/servicos.php');
include_once(ROOT . '/cadastros/database/usuario.php');
include_once '../database/tipoocorrencia.php';

$urlContratoTipo = $_GET["tipo"];
$contratoTipo = buscaContratoTipos($urlContratoTipo);

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


<body class="bg-transparent">

    <div class="container-fluid formContainer">
        <div class="col-sm mt-4" style="text-align:right">
            <a href="index.php?tipo=<?php echo $contratoTipo['idContratoTipo'] ?>" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Inserir <?php echo $contratoTipo['nomeDemanda'] ?></spam>
        </div>
        <div class="container-fluid" style="margin-top: 10px">
            <form id="form" method="post">
                <div class="row">
                    <div class="col-md form-group" style="margin-top: 25px;">
                        <label class='control-label' for='inputNormal' style="margin-top: 4px;">Demanda</label>
                        <input type="text" class="form-control" name="tituloDemanda" autocomplete="off" required>
                        <input type="text" class="form-control" name="idContratoTipo" value="<?php echo $contratoTipo['idContratoTipo'] ?>" style="display: none">
                    </div>
                    <div class="col-md-2 form-group-select">
                        <div class="form-group">
                            <label class="labelForm">Cliente</label>
                            <?php
                            if ($ClienteSession == NULL) { ?>
                                <input type="hidden" class="form-control" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                <select class="select form-control" name="idCliente" autocomplete="off" style="margin-top: -10px;">
                                    <?php
                                    foreach ($clientes as $cliente) {
                                    ?>
                                        <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <input type="text" class="form-control" style="margin-top: -8px;" value="<?php echo $_SESSION['usuario'] ?> - <?php echo $usuario['nomeCliente'] ?>" readonly>
                                <input type="hidden" class="form-control" name="idCliente" value="<?php echo $usuario['idCliente'] ?>" readonly>
                                <input type="hidden" class="form-control" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Descrição</span>
                            </div>
                            <div class="quill-textarea"></div>
                            <textarea style="display: none" id="detail" name="descricao"></textarea>
                        </div>
                    </div>

                    <div class="col-md" style="margin-top: 60px">
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Previsão</label>
                            <input type="number" class="data select form-control" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
                        </div>
                        <div class="col-md-12 form-group-select" style="margin-top: -29px;">
                            <label class="labelForm">Tamanho</label>
                            <select class="select form-control" name="tamanho">
                                <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="G">G</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group-select" style="margin-top: 20px;">
                            <label class="labelForm">Responsável</label>
                            <select class="select form-control" name="idAtendente">
                                <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                <?php foreach ($atendentes as $atendente) { ?>
                                    <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md" style="margin-top: 60px">
                        <div class="col-md-12 form-group-select" style="margin-top: -25px;">
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
                        <div class="col-md-12 form-group-select" style="margin-top: 20px; margin-bottom: 10px">
                            <label class="labelForm">Serviço</label>
                            <select class="select form-control" name="idServico" autocomplete="off">
                                <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                <?php foreach ($servicos as $servico) { ?>
                                    <option value="<?php echo $servico['idServico'] ?>"><?php echo $servico['nomeServico'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12 form-group-select" style="margin-top: 10px; margin-bottom: 10px">
                            <label class="labelForm">Contrato Vinculado</label>
                            <?php if ($contratoTipo['idContratoTipo'] == 'os') { ?>
                                <select class="select form-control" name="idContrato" autocomplete="off" required>
                                <?php } else { ?>
                                    <select class="select form-control" name="idContrato" autocomplete="off">
                                    <?php } ?>

                                    <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                    <?php foreach ($contratos as $contrato) { ?>
                                        <option value="<?php echo $contrato['idContrato'] ?>"><?php echo $contrato['tituloContrato'] ?></option>
                                    <?php } ?>
                                    </select>
                        </div>
                    </div>
                </div>
                <div style="text-align:right">
                    <button type="submit" formaction="../database/demanda.php?operacao=inserir" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?php echo URLROOT ?>/sistema/js/quilljs.js"></script>
</body>

</html>