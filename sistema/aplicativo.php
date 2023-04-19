<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once ('../database/aplicativo.php');

$aplicativos = buscaAplicativos();
//echo json_encode($aplicativos);
?>

<body class="bg-transparent" >
    <div class="container" style="margin-top:30px">

            
            <div class="row mt-4">
                <div class="col-sm-8">
                        <p class="tituloTabela">Aplicativo</p>
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="aplicativo_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
                    </div>
          
            </div>

        <div class="card shadow mt-2">   
            <table class="table">
                <thead>
                    <tr>
                        <th>Aplicativo</th>
                        <th>Imagem</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($aplicativos as $aplicativo) {
                ?>
                    <tr>
                        <td><?php echo $aplicativo['nomeAplicativo'] ?></td>
                        <!-- <td><?php echo $aplicativo['imgAplicativo'] ?></td> -->

                        <td><img height="50" width="100" src="<?php echo $aplicativo['pathImg'];?>" alt=""></td> 

                        <td>
                            <a class="btn btn-primary btn-sm" href="aplicativo_alterar.php?idAplicativo=<?php echo $aplicativo['idAplicativo'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="aplicativo_excluir.php?idAplicativo=<?php echo $aplicativo['idAplicativo'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        
    </div>

</body>

</html>
