<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once '../database/tipostatus.php';

$idTipoStatus = $_GET['idTipoStatus'];

$status = buscaTipoStatus(null,$idTipoStatus);

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="tipostatus.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Alterar Status</spam>
        </div>

        <div class="container" style="margin-top: 30px">

            <form action="../database/tipostatus.php?operacao=alterar" method="post">

                <div class="col-md-12 form-group">
                    <label class='control-label' for='inputNormal'></label>
                    <input type="text" class="form-control" name="nomeTipoStatus" value="<?php echo $status['nomeTipoStatus'] ?>">
                    <input type="text" class="form-control" name="idTipoStatus" value="<?php echo $status['idTipoStatus'] ?>" style="display: none">
                    <div class="row">  
                        <div class="col-md-6">
                            <label class="labelForm">Atendimento(0=Atendente 1=Cliente)</label>
                            <select class="form-control" name="mudaPosicaoPara">
                                <option value="<?php echo $status['mudaPosicaoPara'] ?>"><?php echo $status['mudaPosicaoPara'] ?></option>
                                <option>0</option>
                                <option>1</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="labelForm">Situação (0=Fechado 1=Aberto)</label>
                            <select class="form-control" name="mudaStatusPara">
                                <option value="<?php echo $status['mudaStatusPara'] ?>"><?php echo $status['mudaStatusPara'] ?></option>
                                <option>0</option>
                                <option>1</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="text-align:right">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>