<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Inserir Ocorrência</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="tipoocorrencia.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">

                <form action="../database/tipoocorrencia.php?operacao=inserir" method="post">
                    <label>Nome Ocorrência</label>
                    <div class="form-group" style="margin-top:10px">
                        <input type="text" name="nomeTipoOcorrencia" class="form-control" placeholder="Digite o nome da Ocorrência" autocomplete="off">
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>