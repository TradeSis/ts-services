<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
/* include_once('../head.php');
include_once '../database/tipoocorrencia.php';

$ocorrencias = buscaTipoOcorrencia(); */

?>

<body class="bg-transparent">
    <div class="container" style="margin-top:10px">

            <div class="row mt-4">
                <div class="col-sm-8">
                        <p class="tituloTabela">Ocorrências</p>
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="tipoocorrencia_inserir.php" role="button" class="btn btn-primary">Adicionar Ocorrência</a>
                    </div>
          
            </div>

        <div class="card shadow mt-2">   
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Ocorrência</th>
                        <th class="text-center">Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($ocorrencias as $ocorrencia) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="tipoocorrencia_alterar.php?idTipoOcorrencia=<?php echo $ocorrencia['idTipoOcorrencia'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="tipoocorrencia_excluir.php?idTipoOcorrencia=<?php echo $ocorrencia['idTipoOcorrencia'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        
    </div>

</body>

</html>