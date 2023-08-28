<?php
// Lucas 10032023 - alterado input value= php echo $logado " para value = ($_SESSION['usuario']). linha 68
// Lucas 10032023 - alterado buscaUsuarios($logado) para buscaUsuarios($_SESSION['idUsuario']), linha 18
// gabriel 06032023 11:25 - removido required da descrição
// gabriel 06022023 - removido prioridade, adiciona usuario trade como responsável padrão
// helio 01022023 alterado para include_once
// gabriel 31012023 13:47 - nomeclaturas
// helio 26012023 16:16


include_once '../head.php';
include_once(ROOT.'/cadastros/database/usuario.php');
include_once(ROOT.'/cadastros/database/clientes.php');
include '../database/contratotipos.php';

$urlContratoTipo= $_GET["tipo"];
$contratoTipo = buscaContratoTipos($urlContratoTipo);

$ClienteSession = null;
if (isset($_SESSION['idCliente'])) {
  $ClienteSession = $_SESSION['idCliente'];
}

$usuario = buscaUsuarios(null,$_SESSION['idLogin']);
$clientes = buscaClientes();
?>


<body class="bg-transparent">

    <div class="container formContainer">
            <div class="col-sm mt-4" style="text-align:right">
                <a href="index.php?tipo=<?php echo $contratoTipo['idContratoTipo']?>" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
            <div class="col-sm">
                <spam class="col titulo">Inserir <?php echo $contratoTipo['nomeDemanda']?></spam>
            </div>
        <div class="container" style="margin-top: 10px">
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
                        <div class="col form-group">
                        <label class="labelForm">Descrição</label>
                            <textarea class="form-control" name="descricao" autocomplete="off" rows="10"></textarea>
                        </div>
                    </div>
                    <div  style="text-align:right">
                        <button type="submit" formaction="../database/demanda.php?operacao=inserir" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                    </div>
                </form>
            </div>
    </div>


</body>

</html>