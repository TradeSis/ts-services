<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/menuprograma.php');
include_once('../database/menu.php');
include_once('../database/aplicativo.php');

$menus = buscaMenu();
$aplicativos = buscaAplicativos();
$menuProgr = buscaMenuProgramas($_GET['idMenuPrograma']);
//echo json_encode($menuProgr);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Alterar Menu Programa</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="menuprograma.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/menuprograma.php?operacao=alterar" method="post">
                    <div class="form-group" style="margin-top:10px">

                    <label>Nome</label>
                        <input type="text" name="progrNome" class="form-control"  value="<?php echo $menuProgr['progrNome'] ?>">
                        <input type="text" class="form-control" name="idMenuPrograma" value="<?php echo $menuProgr['idMenuPrograma'] ?>" style="display: none">

                    <label>Menu</label>
                      
                            <select class="form-control" name="IDMenu" autocomplete="off">
                                <option value="<?php echo $menuProgr['IDMenu'] ?>"><?php echo $menuProgr['nomeMenu'] ?></option>
                                        <?php
                                        foreach ($menus as $menu) {
                                        ?>
                                            <option value="<?php echo $menu['IDMenu'] ?>"><?php echo $menu['nomeMenu'] ?></option>
                                        <?php } ?>
                            </select>


                        <label>Aplicativo</label>
                      
                        <select class="form-control" name="idAplicativo" autocomplete="off">
                            <option value="<?php echo $menuProgr['idAplicativo'] ?>"><?php echo $menuProgr['nomeAplicativo'] ?></option>
                                    <?php
                                    foreach ($aplicativos as $aplicativo) {
                                    ?>
                                        <option value="<?php echo $aplicativo['idAplicativo'] ?>"><?php echo $aplicativo['nomeAplicativo'] ?></option>
                                    <?php } ?>
                        </select>


                        <label>link</label>
                        <input type="text" name="progrLink" class="form-control"  value="<?php echo $menuProgr['progrLink'] ?>">
                        <label>Nivel Menu</label>
                        <input type="number" name="nivelMenu" class="form-control"  value="<?php echo $menuProgr['nivelMenu'] ?>"> 

                        
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