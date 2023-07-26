<?php
// helio 26012023 16:16

include_once('../head.php');
?>

<body>

    <div class="container" style="margin-top:30px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="../configuracao/?tab=configuracao&stab=contratoStatus" role="button" class="btn btn-primary"><i
                    class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Contrato Status</spam>
        </div>

        <div class="container" style="margin-top: 30px">

            <form action="../database/contratoStatus.php?operacao=inserir" method="post">
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label class='control-label' for='inputNormal' style="margin-top: -20px;">nome Status</label>
                        <div class="for-group">
                            <input type="text" name="nomeContratoStatus" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top: -7px">
                        <label class="labelForm">Status (0=Fechado 1=Aberto)</label>
                        <select class="form-control" name="mudaStatusPara">
                            <option>0</option>
                            <option>1</option>
                        </select>
                    </div>
                </div>
        </div>
        <div>
            <div style="text-align:right">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
            </div>
        </div>
        </form>
    </div>

    </div>


</body>

</html>