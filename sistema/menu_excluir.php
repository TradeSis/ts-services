<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/menu.php');

$menu = buscaMenu($_GET['IDMenu']);

//echo json_encode($menu);
?>


<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="menu.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Excluir Menu</spam>
        </div>

        <div class="container" style="margin-top: 10px">
            <form action="../database/menu.php?operacao=excluir" method="post">

                <div class="col-md-12 form-group mb-4">
                    <label  class='control-label' for='inputNormal'></label>
                    <input type="text" class="form-control" name="nomeMenu" value="<?php echo $menu['nomeMenu'] ?>">
                    <input type="text" class="form-control" name="IDMenu" value="<?php echo $menu['IDMenu'] ?>" style="display: none">
                </div>
                <div style="text-align:right; margin-top:30px">
                    <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
                </div>
        </div>
        </form>

    </div>



</body>

</html>