<?php
include_once('../head.php');
?>

<body class="bg-transparent">

    <div class="container p-4" style="margin-top:10px">

        <div class="row">
            <div class="col-sm-8">
                <h2 class="tituloTabela">Contrato Tipos</h2>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="../configuracao/?tab=configuracao&stab=contratotipos" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/contratotipos.php?operacao=inserir" method="post">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class='control-label' for='inputNormal' style="margin-top: -5px;">Nome</label>
                    <div class="for-group">
                        <input type="text" name="idContratoTipo" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label class='control-label' for='inputNormal' style="margin-top: -5px;">Nome Contrato</label>
                    <div class="for-group">
                        <input type="text" name="nomeContrato" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label class='control-label' for='inputNormal' style="margin-top: -5px;">Nome Demanda</label>
                    <div class="for-group">
                        <input type="text" name="nomeDemanda" class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>
            <div style="text-align:right;margin-top:20px">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
            </div>
        </form>

    </div>


</body>

</html>