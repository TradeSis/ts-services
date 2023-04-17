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
//echo json_encode($comentarios);

?>
<style>
    .Anexos {
        display: none;
    }

    .Anexos.mostra {
        display: block;
    }
    
    .custom-file-upload {
    /* border: 1px solid #ccc; */
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    color: #fff;
}
::-webkit-file-upload-button {
    opacity: 0;
  
  padding: 0.5em;
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

 
                        <form method="post" id="form" enctype="multipart/form-data">
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
                                    <textarea name="comentario" id="comentario" class="form-control" placeholder="Inserir Comentario" required rows="5"></textarea>
                                    <input type="hidden" name="idDemanda" value="<?php echo $idDemanda ?>" />
                                   
                                    
                                    <div style="text-align:right">
                                    <input type="file" id="myFile" class="custom-file-upload" name="nomeAnexo" onchange="myFunction()">
                                    <label for="myFile">
                                        <a class="btn btn-primary btn-sm"><i class="bi bi-file-earmark-arrow-down-fill" style="color:#fff"></i></a>

                                    </label>
                                    </div>
                                    <p id="mostraNomeAnexo"></p>
                                </div>



                                <div class="card-footer bg-transparent" style="text-align:right">
                                    <input type="submit" name="submit" id="submit" class="btn btn-info btn-sm" value="Comentar" />
                                </div>

                                <?php
                                foreach ($comentarios as $comentario) { ?>
                                    <div class="panel panel-default">
                                        
                                        <div class="panel-body"><?php echo $comentario['comentario'] ?></div>
                                    <div><img height="50" src="<?php echo $comentario['pathAnexo'];?>" alt=""></div> 

                                    <div><a target="_blank" href="<?php echo $comentario['pathAnexo'];?>"><?php echo $comentario['nomeAnexo'] ?></a></div>

                                    <!-- <spam style="font-size: 10px"><?php echo $comentario['nomeAnexo'] ?></spam> -->
                                       <!--  <div class="panel-body"><?php echo $comentario['nomeAnexo'] ?></div> -->
                                       <div class="panel-heading">Comentário de <b><?php echo $comentario['nomeUsuario'] ?></b> em <i><?php echo $comentario['dataComentario'] ?></i></div>
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

function myFunction(){
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
                    txt += "Arquivo a ser anexado: " + "</br>" + "<i>"+ file.name + "</i>" + "<br>";
                }
            }
        }
    }  
    document.getElementById("mostraNomeAnexo").innerHTML = txt;
}


        /*  $(document).ready(function() {

            $('#form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
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
        });  */

        
        $(document).ready(function() {
            $("#form").submit(function() {
                var formData = new FormData(this);

                $.ajax({
                    url: "../database/demanda.php?operacao=comentar",
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