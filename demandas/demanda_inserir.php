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
       
           
                
                   
                    <div class="col-sm mt-4" style="text-align:right">
                        <a href="index.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                    </div>
                    <div class="col-sm">
                        <spam class="col titulo">Inserir Demanda</spam>
                    </div>
            
            <div class="container" style="margin-top: 10px">

                <form id="form" method="post">
                    <div class="row">
                        <div class="col form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: 4px;">Demanda</label>
                            <input type="text" class="form-control" name="tituloDemanda" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col form-group">
                        <label class="labelForm">Descrição</label>
                            <textarea class="form-control" name="descricao" autocomplete="off" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md form-group-select">
                            <div class="form-group">
                                <label class="labelForm">Cliente</label>
                                <?php
                                    if ($usuario['idCliente'] == NULL) { ?>
                                        <input type="hidden" class="form-control" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                        <select class="select form-control" name="idCliente" autocomplete="off" style="margin-top: -10px;">
                                            <?php
                                            foreach ($clientes as $cliente) {
                                            ?>
                                                <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php }
                                    if ($usuario['idCliente']  >= 1) { ?>
                                        <input type="hidden" class="form-control" name="idCliente" value="<?php echo $usuario['idCliente'] ?>" readonly>
                                        <input type="hidden" class="form-control" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['usuario'] ?> - <?php echo $usuario['nomeCliente'] ?>" readonly>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="col-md form-group-select" style="margin-bottom: 80px;">
                            <div class="form-group">
                                <label class="labelForm">Status</label>
                                <select class="select form-control" name="idTipoStatus" style="margin-top: -10px;">
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
                    <div  style="text-align:right">
                        <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                    </div>
                </form>
            </div>
        
    </div>


<script>


$(document).ready(function() {
            $("#form").submit(function() {
                var formData = new FormData(this);

                $.ajax({
                    url: "../database/demanda.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    success: refreshPage(),
                    cache: false,
                    contentType: false,
                    processData: false,
                    
                });

            });

            function refreshPage() {
                window.location.reload();
            }
        });
</script>
</body>

</html>