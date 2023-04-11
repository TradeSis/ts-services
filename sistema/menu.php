<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once ('../database/menu.php');
include_once ('../database/aplicativo.php');

$menus = buscaMenu();
$aplicativos = buscaAplicativos();
//echo json_encode($menus);
?>

<body class="bg-transparent" >
    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Menus</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="menu_inserir.php" role="button" class="btn btn-success btn-sm">Adicionar</a>
                    </div>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Aplicativo</th>
                        <th>Nivel Menu</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($menus as $menu) {
                ?>
                    <tr>
                        <td><?php echo $menu['nomeMenu'] ?></td>
                        <td><?php echo $menu['nomeAplicativo'] ?></td>
                        <td><?php echo $menu['nivelMenu'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="menu_alterar.php?IDMenu=<?php echo $menu['IDMenu'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="menu_excluir.php?IDMenu=<?php echo $menu['IDMenu'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>

        </div>
    </div>

</body>

</html>
