<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../head.php');
include_once('../database/clientes.php');

$clientes = buscaClientes($_GET['idCliente']);

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
       
        <div class="col-sm mt-4" style="text-align:right">
            <a href="clientes.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Excluir Cliente</spam>
        </div>

            <div class="container" style="margin-top: 10px">
                <form action="../database/clientes.php?operacao=excluir" method="post">
                    <div class="col-md-12 form-group mb-4">

                    <label class='control-label' for='inputNormal'></label>
                    <div class="for-group">
                        <input type="text" class="form-control" name="nomeCliente" value="<?php echo $clientes['nomeCliente'] ?>">
                    </div>
                    <input type="text" class="form-control" name="idCliente" value="<?php echo $clientes['idCliente'] ?>" style="display: none">
                </div>
                    <div style="text-align:right">
                    <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
                    </div>
                </form>
            </div>
        
    </div>


</body>

</html>