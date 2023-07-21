<?php
// helio 26012023 16:16
include_once(__DIR__ . '/../database/contratoStatus.php');

$contratoStatus = buscaContratoStatus();


?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        
        
            
            <div class="row mt-4">
                <div class="col-sm-8">
                        <p class="tituloTabela">Contrato Status</p>
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="contratoStatus_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
                    </div>
          
            </div>
        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome Status</th>
                        <th scope="col">Ação</th>

                    </tr>
                </thead>

                <?php

                foreach ($contratoStatus as $contratostatus) {
                ?>
                    <tr>
                        <td>
                            <?php echo $contratostatus['nomeContratoStatus'] ?>
                            <?php //echo json_encode($contratoStatus) ?>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="contratoStatus_alterar.php?idContratoStatus=<?php echo $contratostatus['idContratoStatus'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="contratoStatus_excluir1.php?idContratoStatus=<?php echo $contratostatus['idContratoStatus'] ?>" role="button">Excluir</a>

                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#?idContratoStatus=<?php echo $contratostatus['idContratoStatus'] ?>" role="button">Excluir</a>

                            <div class="modal fade" id="?idContratoStatus=<?php echo $contratostatus['idContratoStatus'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Excluir Status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="card-header">

                                        </div>
                                        <div class="container" style="margin-top: 10px">
                                            <form action="../database/contratoStatus.php?operacao=excluir" method="post">
                                                <div class="form-group" style="margin-top:10px">
                                                    <label>Nome Status</label>
                                                    <input type="text" class="form-control" name="nomeContratoStatus" value="<?php echo $contratostatus['nomeContratoStatus'] ?>">
                                                    <input type="text" class="form-control" name="idContratoStatus" value="<?php echo $contratostatus['idContratoStatus'] ?>" style="display: none">
                                                </div>
                                                <div class="card-footer py-2">
                                                    <div style="text-align:right">
                                                        <button type="submit" class="btn btn-sm btn-success">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>

                <?php } ?>

            </table>
        </div>
    </div>  
   


</body>

</html>