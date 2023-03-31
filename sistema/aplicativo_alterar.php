<?php

include_once('../head.php');
include_once('../database/aplicativo.php');

$aplicativo = buscaAplicativos($_GET['nomeAplicativo']);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Inserir Aplicativo</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="aplicativo.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">

                <form action="../database/aplicativo.php?operacao=alterar" method="post">
                   
                    <div class="form-group" style="margin-top:10px">
                        <label>Aplicativo</label>
                        <input type="text" name="aplicativo" class="form-control"  value="<?php echo $aplicativo['aplicativo'] ?>"> <!-- style="display: none" -->
                        <label>Nome Aplicativo</label>
                        <input type="text" name="nomeAplicativo" class="form-control"  value="<?php echo $aplicativo['nomeAplicativo'] ?>">
                        <label>Imagem</label>
                        <input type="text" name="imgAplicativo" class="form-control"  value="<?php echo $aplicativo['imgAplicativo'] ?>">
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">

                        <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>