<?php

include_once('../head.php');
include_once ('../database/aplicativo.php');

$aplicativos = buscaAplicativos();
//echo json_encode($aplicativos);
?>

<body class="bg-transparent" >
    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Aplicativo</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="aplicativo_inserir.php" role="button" class="btn btn-success btn-sm">Adicionar</a>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Aplicativo</th>
                        <th>nomeAplicativo</th>
                        <th>Imagem</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($aplicativos as $aplicativo) {
                ?>
                    <tr>
                        <td><?php echo $aplicativo['aplicativo'] ?></td>
                        <td><?php echo $aplicativo['nomeAplicativo'] ?></td>
                        <td><?php echo $aplicativo['imgAplicativo'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="aplicativo_alterar.php?aplicativo=<?php echo $aplicativo['aplicativo'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="aplicativo_excluir.php?aplicativo=<?php echo $aplicativo['aplicativo'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>

        </div>
    </div>

</body>

</html>