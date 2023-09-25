<?php
include_once '../head.php';
?>


<body class="bg-transparent">

    <div class="container-fluid">
        <form method="post" id="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
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

                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Descrição</span>
                            </div>
                            <div class="quill-comentario"></div>
                            <textarea style="display: none" id="quill-comentario" name="comentario"></textarea>
                        </div>

                        <!-- <textarea name="comentario" id="comentario" class="form-control" placeholder="Inserir Comentario" rows="5"></textarea> -->
                        <input type="hidden" name="idDemanda" value="<?php echo $idDemanda ?>" />
                        <input type="hidden" name="tipoStatusDemanda" value="<?php echo $idTipoStatus ?>" />


                        <div class="mt-2" style="text-align:right">
                            <input type="file" id="myFile" class="custom-file-upload" name="nomeAnexo" onchange="myFunction()" style="color:#567381; display:none">
                            <label for="myFile">
                                <a class="btn btn-primary"><i class="bi bi-file-earmark-arrow-down-fill" style="color:#fff"></i>&#32;<h7 style="color: #fff;">Anexos</h7></a>

                            </label>
                        </div>
                        <p id="mostraNomeAnexo"></p>
                    </div>

                    <div class="row">
                        <div class="col-md ml-auto">
                            <?php
                            if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO) { ?>
                                <button type="submit" formaction="../database/demanda.php?operacao=validar" class="btn btn-danger" style="margin-right:10px;float: left;">Validar</button>
                            <?php }
                            if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO || $demanda['idTipoStatus'] == TIPOSTATUS_VALIDADO) { ?>
                                <button type="submit" formaction="../database/demanda.php?operacao=retornar" class="btn btn-warning" style="margin-right:10px;float: left;">Retornar</button>
                            <?php } ?>
                            <?php
                            if ($ClienteSession == NULL) { ?>
                                <button type="submit" formaction="../database/demanda.php?operacao=comentarAtendente" class="btn btn-info" style="float: right;">Comentar</button>
                                <button type="submit" formaction="../database/demanda.php?operacao=solicitar" class="btn btn-warning" style="margin-right:10px;float: right;">Encaminhar</button>
                            <?php } //*************** visão cliente
                            if ($ClienteSession >= 1) { ?>
                                <button type="submit" formaction="../database/demanda.php?operacao=comentar" class="btn btn-info" style="margin-right:20px;float: right;">Enviar</button>
                            <?php } ?>

                        </div>
                    </div>

                    <!-- <h4 class="mt-5">Anexos:</h4>
                    <div class="card"></div> -->

                </div>
                <div class="container mt-3 col-md-6" style="float:left">
                    <?php foreach ($comentarios as $comentario) {  ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <p>
                                            <a class="float-left"><strong>
                                                    <?php echo $comentario['nomeUsuario'] ?>
                                                </strong></a>
                                            <span class="float-right">
                                                <?php echo date('H:i d/m/Y', strtotime($comentario['dataComentario'])) ?>
                                            </span>
                                        </p>
                                        <div class="clearfix"></div>
                                        <p>
                                            <?php echo $comentario['comentario'] ?>
                                        </p>
                                        <p>
                                            <?php if ($comentario['pathAnexo'] != '') { ?>
                                                <span>anexo:</span>
                                                <a target="_blank" href="<?php echo $comentario['pathAnexo'] ?>"><?php echo $comentario['nomeAnexo'] ?></a>
                                                <span class="float-right">
                                                    <a href="<?php echo $comentario['pathAnexo'] ?>">
                                                        <i class="bi bi-file-earmark-arrow-down-fill" style="font-size: 2rem;"></i>
                                                    </a>
                                                </span>

                                            <?php } else {  ?>
                                                <a target="_blank" href="<?php echo $comentario['pathAnexo'] ?>"><?php echo $comentario['nomeAnexo'] ?></a>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
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

    <script>
        var quillcomentario = new Quill('.quill-comentario', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }], 
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                ]
            }
        });

        quillcomentario.on('text-change', function(delta, oldDelta, source) {
            $('#quill-comentario').val(quillcomentario.container.firstChild.innerHTML);
        });
    </script>
</body>