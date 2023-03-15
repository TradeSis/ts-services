<?php
// Lucas 10032023 - alterado input value= php echo $logado " para value = ($_SESSION['usuario']). linha 68
// Lucas 10032023 - alterado buscaUsuarios($logado) para buscaUsuarios($_SESSION['idUsuario']), linha 18
// gabriel 06032023 11:25 - removido required da descrição
// gabriel 06022023 - removido prioridade, adiciona usuario trade como responsável padrão
// helio 01022023 alterado para include_once
// gabriel 31012023 13:47 - nomeclaturas
// helio 26012023 16:16


include_once '../head.php';
include_once '../database/usuario.php';
include_once '../database/clientes.php';
include_once '../database/tipostatus.php';
include_once '../database/tipoocorrencia.php';

$tiposstatus = buscaTipoStatus(1);
$ocorrencias = buscaTipoOcorrencia(1);
$usuario = buscaUsuarios($_SESSION['idUsuario']);
$clientes = buscaClientes();
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Inserir Demanda</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">

                <form action="../database/demanda.php?operacao=inserir" method="post">
                    <div class="row">
                        <div class="col">
                            <label>Demanda</label>
                            <input type="text" class="form-control" name="tituloDemanda" placeholder="Nome do incidente" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea class="form-control" name="descricao" placeholder="Insira o problema" autocomplete="off" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label>Cliente</label>
                                <?php
                                    if ($usuario['idCliente'] == NULL) { ?>
                                        <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                        <select class="form-control" name="idCliente" autocomplete="off">
                                            <?php
                                            foreach ($clientes as $cliente) {
                                            ?>
                                                <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php }
                                    if ($usuario['idCliente']  >= 1) { ?>
                                        <input type="hidden" class="form-control" name="idCliente" value="<?php echo $usuario['idCliente'] ?>" readonly>
                                        <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['usuario'] ?> - <?php echo $usuario['nomeCliente'] ?>" readonly>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="idTipoStatus">
                                    <?php
                                    foreach ($tiposstatus as $tipostatus) {
                                    ?>
                                        <option value="<?php echo $tipostatus['idTipoStatus'] ?>"><?php echo $tipostatus['nomeTipoStatus'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="idTipoOcorrencia" value="<?php echo $ocorrencias['idTipoOcorrencia'] ?>" readonly>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</body>

</html>