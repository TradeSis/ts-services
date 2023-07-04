<body class="bg-transparent">
    <div class="container-fluid mb-3">
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
                    <textarea name="comentario" id="comentario" class="form-control" placeholder="Inserir Comentario"
                        required rows="5"></textarea>
                    <input type="hidden" name="idDemanda" value="<?php echo $idDemanda ?>" />
                    <input type="hidden" name="tipoStatusDemanda" value="<?php echo $idTipoStatus ?>" />


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
                        class="btn btn-info" style="margin-right:10px;float: right;">Comentar</button>
                    <button type="submit" formaction="../database/demanda.php?operacao=solicitar" class="btn btn-warning"
                        style="margin-right:10px;float: right;">Solicitar</button>
                <?php } //*************** visão cliente
                if ($_SESSION['idCliente'] >= 1) { ?>
                    <button type="submit" formaction="../database/demanda.php?operacao=comentar" class="btn btn-info"
                        style="margin-right:20px;float: right;">Comentar</button>
                <?php } ?>

                <?php
                foreach ($comentarios as $comentario) { ?>
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <?php echo $comentario['comentario'] ?>
                        </div>
                        <div><img height="50" src="<?php echo $comentario['pathAnexo']; ?>" alt=""></div>

                        <a class="btn btn-primary btn-sm" target="_blank" href="<?php echo $comentario['pathAnexo']; ?>"
                            style="margin-top:5px;margin-right:10px"><i class="bi bi-file-earmark-arrow-down-fill"
                                style="color:#fff"></i></a>
                        <?php echo $comentario['nomeAnexo'] ?>


                        <div class="panel-heading">Comentário de <b>
                                <?php echo $comentario['nomeUsuario'] ?>
                            </b> em <i>
                                <?php echo $comentario['dataComentario'] ?>
                            </i></div>
                        <div class="card-footer bg-transparent"></div>

                    </div>
                    <br />
                <?php } ?>
            </div>
        </form>
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

