<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once '../database/tipoocorrencia.php';

$idTipoOcorrencia = $_GET['idTipoOcorrencia'];

$ocorrencias = buscaTipoOcorrencia(null, $idTipoOcorrencia);

?>

<body class="bg-transparent">

    <div class="container p-4" style="margin-top:10px">

        <div class="row">
            <div class="col-sm">
                <h2 class="tituloTabela">Alterar Ocorrência</h2>
            </div>
            <div class="col-sm mt-4" style="text-align:right">
                <a href="../configuracao/?tab=configuracao&stab=tipoocorrencia" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/tipoocorrencia.php?operacao=alterar" method="post">

            <div class="col-md-12 form-group">
                <label class='control-label' for='inputNormal'></label>
                <input type="text" class="form-control" name="nomeTipoOcorrencia" value="<?php echo $ocorrencias['nomeTipoOcorrencia'] ?>">
                <input type="text" class="form-control" name="idTipoOcorrencia" value="<?php echo $ocorrencias['idTipoOcorrencia'] ?>" style="display: none">
            </div>

            <div style="text-align:right; margin-top:20px">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>


</body>

</html>