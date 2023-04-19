<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/menuprograma.php');

$menuProgr = buscaMenuProgramas($_GET['idMenuPrograma']);

//echo json_encode($menuProgr);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:30px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="menuprograma.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Excluir Programa</spam>
        </div>

        <div class="container" style="margin-top: 10px">
            <form action="../database/menuprograma.php?operacao=excluir" method="post">

                <div class="col-md-12 form-group">
                    <label class="labelForm">Aplicativo</label>
                    <input type="text" class="form-control" name="progrNome" value="<?php echo $menuProgr['progrNome'] ?>">
                    <input type="text" class="form-control" name="idMenuPrograma" value="<?php echo $menuProgr['idMenuPrograma'] ?>" style="display: none">
                </div>
                <div style="text-align:right; margin-top:30px">
                <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>


</body>

</html>