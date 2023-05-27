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
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Alterar Status</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="tipostatus.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/tipostatus.php?operacao=alterar" method="post">
                    <div class="form-group" style="margin-top:10px">
                        <label>Nome Status</label>
                        <input type="text" class="form-control" name="nomeTipoStatus" value="<?php echo $status['nomeTipoStatus'] ?>">
                        <input type="text" class="form-control" name="idTipoStatus" value="<?php echo $status['idTipoStatus'] ?>" style="display: none">
                        <label style="margin-top:10px">Atendimento(0=Atendente 1=Cliente)</label>
                        <select class="form-control" name="mudaPosicaoPara">
                            <option>0</option>
                            <option>1</option>
                        </select>
                        <label style="margin-top:10px">Situação (0=Fechado 1=Aberto)</label>
                        <select class="form-control" name="mudaStatusPara">
                            <option>0</option>
                            <option>1</option>
                        </select>
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Alterar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>