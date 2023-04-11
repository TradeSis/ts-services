<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/aplicativo.php');

$aplicativo = buscaAplicativos($_GET['idAplicativo']);

//echo json_encode($aplicativo);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Excluir Aplicativo</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="aplicativo.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/aplicativo.php?operacao=excluir" method="post">
                    <div class="form-group" style="margin-top:10px">
                        <label>Aplicativo</label>
                        <input type="text" class="form-control" name="nomeAplicativo" value="<?php echo $aplicativo['nomeAplicativo'] ?>">
                        <input type="text" class="form-control" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>" style="display: none">
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>