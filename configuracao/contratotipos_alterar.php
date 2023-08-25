<?php
include_once('../head.php');
include_once '../database/contratotipos.php';

$idContratoTipo = $_GET['idContratoTipo'];

$contratotipo = buscaContratoTipos($idContratoTipo);

?>

<body class="bg-transparent">

    <div class="container p-4" style="margin-top:10px">

        <div class="row">
            <div class="col-sm">
                <h2 class="tituloTabela">Alterar Contrato Tipos</h2>
            </div>
            <div class="col-sm mt-4" style="text-align:right">
                <a href="../configuracao/?tab=configuracao&stab=contratotipos" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/contratotipos.php?operacao=alterar" method="post">

            <div class="col-md-12 form-group">
                <label class='control-label' for='inputNormal'></label>
                <input type="text" class="form-control" name="nomeContratoTipo" value="<?php echo $contratotipo['nomeContratoTipo'] ?>">
                <input type="text" class="form-control" name="idContratoTipo" value="<?php echo $contratotipo['idContratoTipo'] ?>" style="display: none">
            </div>

            <div style="text-align:right; margin-top:20px">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>


</body>

</html>