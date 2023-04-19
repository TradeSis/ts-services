<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/menu.php');
include_once('../database/aplicativo.php');

$menus = buscaMenu();
$aplicativos = buscaAplicativos();
?>


<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="menuprograma.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Inserir Menu Programa</spam>
        </div>

        <div class="container" style="margin-top: 10px">

            <form action="../database/menuprograma.php?operacao=inserir" method="post">

            <div class="row">

                <div class="col-md-6 form-group">
                    <label class="labelForm">Nome</label>
                    <input type="text" name="progrNome" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-3 form-group-select" style="margin-top: 30px;">
                    <label class="labelForm">Menu</label>
                    <select class="select form-control" name="IDMenu">
                        <?php
                        foreach ($menus as $menu) {
                        ?>
                            <option value="<?php echo $menu['IDMenu'] ?>"><?php echo $menu['nomeMenu']  ?></option>
                        <?php  } ?>
                    </select>
                </div>

                <div class="col-md-3 form-group-select" style="margin-top: 30px;"">
                <label class="labelForm">Aplicativo</label>
                    <select class="select form-control" name="idAplicativo">
                        <?php
                        foreach ($aplicativos as $aplicativo) {
                        ?>
                            <option value="<?php echo $aplicativo['idAplicativo'] ?>"><?php echo $aplicativo['nomeAplicativo']  ?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>

                    

                    <label class="labelForm">link</label>
                    <input type="text" name="progrLink" class="form-control" autocomplete="off">
                    <div class="col-md-2" style="margin-left:-10px">
                        <label class="labelForm mt-3">Nivel Menu</label>
                        <input type="number" name="nivelMenu" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div style="text-align:right; margin-top:30px">

                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script src="../js/input.js"></script>
</body>

</html>