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

<body class="bg-transparent">
    <div class="container-fluid mt-3">
        <?php
        if ($_SESSION['idCliente'] == NULL) { ?>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" style="color:blue"
                        href="comentarios.php?idDemanda=<?php echo $idDemanda ?>">Comentarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"
                        href="visualizar_tarefa.php?idDemanda=<?php echo $idDemanda ?>">Tarefas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"
                        href="previsao.php?idDemanda=<?php echo $idDemanda ?>">Previsão</a>
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


                <form method="post" id="form" enctype="multipart/form-data">
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php
                            $nomeCliente = "Interno";
                            if ($usuario["idCliente"]) {
                                $clientes = buscaClientes($usuario["idCliente"]);
                                $nomeCliente = $clientes["nomeCliente"];
                            } ?>
                            <input type="hidden" class="form-control" name="idCliente"
                                value="<?php echo $usuario['idCliente'] ?>" readonly>
                            <input type="hidden" class="form-control" name="idUsuario"
                                value="<?php echo $usuario['idUsuario'] ?>" readonly>
                            <input type="text" class="form-control"
                                value="<?php echo $_SESSION['usuario'] ?> - <?php echo $nomeCliente ?>" readonly>
                        </div>
                        <div class="form-group">
                            <textarea name="comentario" id="comentario" class="form-control"
                                placeholder="Inserir Comentario" required rows="5"></textarea>
                            <input type="hidden" name="idDemanda" value="<?php echo $idDemanda ?>" />


                            <div style="text-align:right">
                                <input type="file" id="myFile" class="custom-file-upload" name="nomeAnexo"
                                    onchange="myFunction()">
                                <label for="myFile">
                                    <a class="btn btn-primary"><i class="bi bi-file-earmark-arrow-down-fill"
                                            style="color:#fff"></i></a>

                                </label>
                            </div>
                            <p id="mostraNomeAnexo"></p>
                        </div>



                        <?php
                        if ($_SESSION['idCliente'] == NULL) { ?>
                            <button type="submit" formaction="../database/demanda.php?operacao=comentarAtendente"
                                class="btn btn-info" style="margin-right:20px;float: right;">Comentar</button>
                        <?php } //*************** visão cliente
                        if ($_SESSION['idCliente'] >= 1) { ?>
                            <button type="submit" formaction="../database/demanda.php?operacao=comentar"
                                class="btn btn-info" style="margin-right:20px;float: right;">Comentar</button>
                        <?php } ?>

                        <?php
                        foreach ($comentarios as $comentario) { ?>
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <?php echo $comentario['comentario'] ?>
                                </div>
                                <div><img height="50" src="<?php echo $comentario['pathAnexo']; ?>" alt=""></div>

                                <a class="btn btn-primary btn-sm" target="_blank"
                                    href="<?php echo $comentario['pathAnexo']; ?>"
                                    style="margin-top:5px;margin-right:10px"><i class="bi bi-file-earmark-arrow-down-fill"
                                        style="color:#fff"></i></a>
                                <?php echo $comentario['nomeAnexo'] ?>



                                <!-- <spam style="font-size: 10px"><?php echo $comentario['nomeAnexo'] ?></spam> -->
                                <!--  <div class="panel-body"><?php echo $comentario['nomeAnexo'] ?></div> -->
                                <div class="panel-heading">Comentário de <b>
                                        <?php echo $comentario['nomeUsuario'] ?>
                                    </b> em <i>
                                        <?php echo $comentario['dataComentario'] ?>
                                    </i></div>
                                <!-- <div>------------------------------------------------------</div> -->
                                <div class="card-footer bg-transparent"></div>

                            </div>
                            <br />
                        <?php } ?>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>

        function myFunction() {
            var x = document.getElementById("myFile");
            var txt = "";
            if ('files' in x) {
                if (x.files.length == 0) {
                    txt = "";
                } else {
                    for (var i = 0; i < x.files.length; i++) {
                        /* txt += "<br><strong>" + (i+1) + ". file</strong><br>"; */
                        var file = x.files[i];
                        if ('name' in file) {
                            txt += "Arquivo a ser anexado: " + "</br>" + "<i>" + file.name + "</i>" + "<br>";
                        }
                    }
                }
            }
            document.getElementById("mostraNomeAnexo").innerHTML = txt;
        }



    </script>
</body>

</html>