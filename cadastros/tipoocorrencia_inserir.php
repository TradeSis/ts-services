<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="tipoocorrencia.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Tipo de Ocorrência</spam>
        </div>
        
        <div class="container" style="margin-top: 30px">

            <form action="../database/tipoocorrencia.php?operacao=inserir" method="post">

            <div class="col-md-12 form-group">  
                <label class='control-label' for='inputNormal' style="margin-top: -20px;">Tipo Ocorrência</label>
                <div class="for-group">
                    <input type="text" name="nomeTipoOcorrencia" class="form-control"  autocomplete="off">
                </div>
            </div>
                <div style="text-align:right">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>