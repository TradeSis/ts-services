<?php
// helio 26012023 16:16

include '../head.php';
include '../database/contratoStatus.php';

$idContratoStatus = $_GET['idContratoStatus'];

$contratoStatus = buscaContratoStatus($idContratoStatus);

?>

<body class="bg-transparent">

    <div class="container p-4" style="margin-top:10px">

        <div class="row">
            <div class="col-sm-8">
                <h2 class="tituloTabela">Alterar Status</h2>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="../configuracao/?tab=configuracao&stab=contratoStatus" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/contratoStatus.php?operacao=alterar" method="post">

            <div class="row">
                <div class="col-md-8 form-group mb-4">
                    <label class='control-label mb-2' for='inputNormal'></label>
                    <div class="for-group">
                        <input type="text" class="form-control" name="nomeContratoStatus" value="<?php echo $contratoStatus['nomeContratoStatus'] ?>">
                        <input type="text" class="form-control" name="idContratoStatus" value="<?php echo $contratoStatus['idContratoStatus'] ?>" style="display: none">
                    </div>
                </div>
                <div class="col-md-4" style="margin-top: -7px">
                    <label class="labelForm">Status (0=Fechado 1=Aberto)</label>
                    <select class="form-control" name="mudaStatusPara">
                        <option value="<?php echo $contratoStatus['mudaStatusPara'] ?>"><?php echo $contratoStatus['mudaStatusPara'] ?></option>
                        <option>0</option>
                        <option>1</option>
                    </select>
                </div>
            </div>

            <div style="text-align:right; margin-top:20px">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>


</body>

</html>