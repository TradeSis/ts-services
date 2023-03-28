<?php
// gabriel 220323 11:19 - adicionado IF para usuario cliente
// Lucas 10032023 - alterado input value= php echo $logado " para value = ($_SESSION['usuario']). linha 42
// Lucas 10032023 - alterado buscaUsuarios($logado) para buscaUsuarios($_SESSION['idUsuario'])
// gabriel 09022023 14:20 removido alguns ifs redundantes, fechado div container
// gabriel 03022023 17:04 - nav adicionada, comentarios.php separado, nomeclaturas alteradas
// helio 01022023 alterado para include_once

include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/usuario.php';
include_once '../database/clientes.php';

$idDemanda = $_GET['idDemanda'];
$usuario = buscaUsuarios($_SESSION['idUsuario']);
$comentarios = buscaComentarios($idDemanda);

?>
<style>
    .Anexos {
        display: none;
    }

    .Anexos.mostra {
        display: block;
    }
</style>

<body class="bg-transparent">
    <div class="container-fluid mt-3">
        <?php
        if ($_SESSION['idCliente'] == NULL) { ?>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="comentarios.php?idDemanda=<?php echo $idDemanda ?>">Comentarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="visualizar_tarefa.php?idDemanda=<?php echo $idDemanda ?>">Tarefas</a>
                </li>
            </ul>
        <?php }
        if ($_SESSION['idCliente'] >= 1) { ?>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="comentarios.php?idDemanda=<?php echo $idDemanda ?>">Comentarios</a>
                </li>
            </ul>
        <?php } ?>

        <div>
            <div class="container-fluid mt-3">

                <div class="row">
                    <div class="col-sm-1">
                        <button class="btnAnexos btn btn-primary"><i class="bi bi-file-earmark-arrow-down-fill"></i></button>
                    </div>

                    <div class="col-sm">
                        <form method="post" id="form">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <?php
                                    $nomeCliente = "Interno";
                                    if ($usuario["idCliente"]) {
                                        $clientes = buscaClientes($usuario["idCliente"]);
                                        $nomeCliente = $clientes["nomeCliente"];
                                    } ?>
                                    <input type="hidden" class="form-control" name="idCliente" value="<?php echo $usuario['idCliente'] ?>" readonly>
                                    <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['usuario'] ?> - <?php echo $nomeCliente ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <textarea name="comentario" id="comentario" class="form-control" placeholder="Inserir Comentario" rows="5"></textarea>
                                    <input type="hidden" name="idDemanda" value="<?php echo $idDemanda ?>" />
                                </div>


                              <!--   <div class="row">
                                    <div class="mb-3">
                                        <label for="formFileSm" class="form-label">Small file input example</label>
                                        <input class="form-control form-control-sm" id="formFileSm" type="file">
                                    </div>
                                </div> -->
                                

                                <div class="card-footer bg-transparent" style="text-align:right">
                                    <input type="submit" name="submit" id="submit" class="btn btn-info btn-sm" value="Comentar" />
                                </div>
                                <?php
                                foreach ($comentarios as $comentario) { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Comentário de <b><?php echo $comentario['nomeUsuario'] ?></b> em <i><?php echo $comentario['dataComentario'] ?></i></div>
                                        <div class="panel-body"><?php echo $comentario['comentario'] ?></div>
                                    </div>
                                    <br />
                                <?php } ?>
                            </div>
                        </form>


                    </div>
                </div>



                <!--TESTE ANEXOS-->
                <div class="container Anexos">
                    <form action="bdAnexos.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Inserir Anexo</label>
                            <input type="file" name='arquivo' class="form-control-file" id="exampleFormControlFile1">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Anexar</button>
                    </form>

                </div>



                <!--TESTE ANEXOS-->
            </div>
        </div>
    </div>

    <script>
        $('.btnAnexos').click(function() {
            $('.Anexos').toggleClass('mostra');
        });


        $(document).ready(function() {

            $('#form').on('submit', function(event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: "../database/demanda.php?operacao=comentar",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                })
            });

            function refreshPage() {
                window.location.reload();
            }
        });

        $(document).ready(function() {

            $('#form').on('submit', function(event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: "bdAnexos.php",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                })
            });

            function refreshPage() {
                window.location.reload();
            }
        });
    </script>
</body>

</html>