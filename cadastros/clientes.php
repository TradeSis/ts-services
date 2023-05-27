<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../head.php');
include_once('../database/clientes.php');

$clientes = buscaClientes();
//echo json_encode($clientes);

?>

<body class="bg-transparent">
    <div class="container" style="margin-top:30px"> 
        
            <div class="row mt-4">
                <div class="col-sm-8">
                        <p class="tituloTabela">Clientes</p>
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="clientes_inserir.php" role="button" class="btn btn-primary">Adicionar Cliente</a>
                    </div>
          
            </div>
        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($clientes as $cliente) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $cliente['nomeCliente'] ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="clientes_alterar.php?idCliente=<?php echo $cliente['idCliente'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="clientes_excluir.php?idCliente=<?php echo $cliente['idCliente'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>


</body>

</html>