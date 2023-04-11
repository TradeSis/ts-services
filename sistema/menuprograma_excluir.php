<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/menuprograma.php');

$menuProgr = buscaMenuProgramas($_GET['idMenuPrograma']);

//echo json_encode($menuProgr);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Excluir Programa</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="menuprograma.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/menuprograma.php?operacao=excluir" method="post">
                    <div class="form-group" style="margin-top:10px">
                        <label>Aplicativo</label>
                        <input type="text" class="form-control" name="progrNome" value="<?php echo $menuProgr['progrNome'] ?>">
                        <input type="text" class="form-control" name="idMenuPrograma" value="<?php echo $menuProgr['idMenuPrograma'] ?>" style="display: none">
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>