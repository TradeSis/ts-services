<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once '../database/tipostatus.php';

$idTipoStatus = $_GET['idTipoStatus'];

$status = buscaTipoStatus($idTipoStatus);

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="tipostatus.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Excluir Status</spam>
        </div>

        <div class="container" style="margin-top: 30px">
            <form action="../database/tipostatus.php?operacao=excluir" method="post">

                <div class="col-md-12 form-group">
                    <label class='control-label' for='inputNormal'></label>
                    <input type="text" class="form-control" name="nomeTipoStatus" value="<?php echo $status['nomeTipoStatus'] ?>">
                    <input type="text" class="form-control" name="idTipoStatus" value="<?php echo $status['idTipoStatus'] ?>" style="display: none">
                </div>
                <div class="card-footer bg-transparent" style="text-align:right">
                    <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>