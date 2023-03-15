<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once('../database/usuario.php');


$usuarios = buscaUsuarios($_GET['$idUsuario']);

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Excluir Usuário</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="usuario.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/usuario.php?operacao=excluir" method="post">
                    <div class="form-group" style="margin-top:10px">
                        <label>Nome Usuário</label>
                        <input type="text" class="form-control" name="nomeUsuario" value="<?php echo $usuarios['nomeUsuario'] ?>">
                        <input type="text" class="form-control" name="idUsuario" value="<?php echo $usuarios['idUsuario'] ?>" style="display: none">
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