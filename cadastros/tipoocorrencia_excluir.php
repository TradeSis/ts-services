<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once '../database/tipoocorrencia.php';

$idTipoOcorrencia = $_GET['idTipoOcorrencia'];

$ocorrencias = buscaTipoOcorrencia($idTipoOcorrencia);

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="tipoocorrencia.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Excluir Ocorrência</spam>
        </div>

        <div class="container" style="margin-top: 30px">

            <form action="../database/tipoocorrencia.php?operacao=excluir" method="post">
                <div class="col-md-12 form-group">
                    <label class='control-label' for='inputNormal'></label>
                    <input type="text" class="form-control" name="nomeTipoOcorrencia" value="<?php echo $ocorrencias['nomeTipoOcorrencia'] ?>">
                    <input type="text" class="form-control" name="idTipoOcorrencia" value="<?php echo $ocorrencias['idTipoOcorrencia'] ?>" style="display: none">
                </div>
                <div style="text-align:right">
                <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>