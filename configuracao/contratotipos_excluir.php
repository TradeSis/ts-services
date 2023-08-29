<?php
include_once('../head.php');
include_once '../database/contratotipos.php';

$idContratoTipo = $_GET['idContratoTipo'];

$contratotipo = buscaContratoTipos($idContratoTipo);

?>

<body class="bg-transparent">

    <div class="container p-4" style="margin-top:10px">

        <div class="row">
            <div class="col-sm-8">
                <h2 class="tituloTabela">Excluir Contrato Tipos</h2>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="../configuracao/?tab=configuracao&stab=contratotipos" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/contratotipos.php?operacao=excluir" method="post">
            <div class="col-md-12 form-group">
                <label class='control-label' for='inputNormal'></label>
                <input type="text" class="form-control" name="idContratoTipo" value="<?php echo $contratotipo['idContratoTipo'] ?>" disabled>
            </div>

            <div style="text-align:right; margin-top:20px">
                <button type="submit" id="botao" class="btn btn-sm btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
            </div>
        </form>


    </div>


</body>

</html>