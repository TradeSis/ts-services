<?php

include_once('../head.php');
include_once ('../database/menuprograma.php');

$menuProgramas = buscaMenuProgramas();
//echo json_encode($menuProgr);
?>

<body class="bg-transparent" >
    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Menu Programas</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="menuprograma_inserir.php" role="button" class="btn btn-success btn-sm">Adicionar</a>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>IDMenu</th>
                        <th>progrNome</th>
                        <th>Aplicativo</th>
                        <th>progrLink</th>
                        <th>nivelMenu</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($menuProgramas as $menuProgr) {
                ?>
                    <tr>
                        <td><?php echo $menuProgr['IDMenu'] ?></td>
                        <td><?php echo $menuProgr['progrNome'] ?></td>
                        <td><?php echo $menuProgr['aplicativo'] ?></td>
                        <td><?php echo $menuProgr['progrLink'] ?></td>
                        <td><?php echo $menuProgr['nivelMenu'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="menuprograma_alterar.php?progrNome=<?php echo $menuProgr['progrNome'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="menuprograma_excluir.php?progrNome=<?php echo $menuProgr['progrNome'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>

        </div>
    </div>

</body>

</html>
