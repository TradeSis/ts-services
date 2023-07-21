<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
/* include_once('../head.php');
include_once '../database/tipostatus.php';

$tiposstatus = buscaTipoStatus(); */
?>

<body class="bg-transparent" >
    <div class="container" style="margin-top:10px">

            <div class="row mt-4">
                <div class="col-sm-8">
                        <p class="tituloTabela">Tipos de Status</p>
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="tipostatus_inserir.php" role="button" class="btn btn-primary">Adicionar Status</a>
                    </div>
          
            </div>

        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($tiposstatus as $tipostatus) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $tipostatus['nomeTipoStatus'] ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="tipostatus_alterar.php?idTipoStatus=<?php echo $tipostatus['idTipoStatus'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="tipostatus_excluir.php?idTipoStatus=<?php echo $tipostatus['idTipoStatus'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        
    </div>

</body>

</html>
