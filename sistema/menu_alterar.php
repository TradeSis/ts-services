<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/menu.php');
include_once('../database/aplicativo.php');

$aplicativos = buscaAplicativos();

$menu = buscaMenu($_GET['IDMenu']);
//echo json_encode($menu);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Alterar Menu</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="menu.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/menu.php?operacao=alterar" method="post">
                    <div class="form-group" style="margin-top:10px">
                        <label>Menu</label>
                        <input type="text" class="form-control" name="nomeMenu" value="<?php echo $menu['nomeMenu'] ?>">
                        <input type="text" class="form-control" name="IDMenu" value="<?php echo $menu['IDMenu'] ?>" style="display: none">

                        
                            <label>Aplicativo</label>
                            <select class="form-control" name="idAplicativo">
                                <?php
                                    foreach ($aplicativos as $aplicativo) {
                                ?>
                                <option value="<?php echo $aplicativo['idAplicativo'] ?>"><?php echo $aplicativo['nomeAplicativo']  ?></option>
                                <?php  } ?>
                            </select>

                        
                            <label>Nivel Menu</label>
                            <input type="number" class="form-control" name="nivelMenu" value="<?php echo $menu['nivelMenu'] ?>">
                        

                        
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Alterar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>