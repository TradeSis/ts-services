<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once('../database/usuario.php');


$usuarios = buscaUsuarios($_GET['$idUsuario']);

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:30px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="usuario.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Excluir Usuário</spam>
        </div>

        <div class="container" style="margin-top: 10px">
            <form action="../database/usuario.php?operacao=excluir" method="post">

                <div class="col-md-12 form-group">
                    <label class='control-label' for='inputNormal'></label>
                    <input type="text" class="form-control" name="nomeUsuario" value="<?php echo $usuarios['nomeUsuario'] ?>">
                    <input type="text" class="form-control" name="idUsuario" value="<?php echo $usuarios['idUsuario'] ?>" style="display: none">
                </div>
                <div style="text-align:right">
                    <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>