<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/aplicativo.php');

$aplicativos = buscaAplicativos();
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="col-sm mt-4" style="text-align:right">
            <a href="menu.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
        </div>
        <div class="col-sm">
            <spam class="col titulo">Inserir Menu</spam>
        </div>

        <div class="container" style="margin-top: 30px">

            <form action="../database/menu.php?operacao=inserir" method="post">

            <div class="row">
                <div class="col-md-12 form-group">

                    <label class='control-label' for='inputNormal'>Menu</label>
                    <input type="text" name="nomeMenu" class="form-control" autocomplete="off">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3 form-group-select">
                    
                        <label class="labelForm">Aplicativo</label>
                        <select class="select form-control" name="idAplicativo">
                            <?php
                            foreach ($aplicativos as $aplicativo) {
                            ?>
                                <option value="<?php echo $aplicativo['idAplicativo'] ?>"><?php echo $aplicativo['nomeAplicativo']  ?></option>
                            <?php  } ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group" style="margin-top: -10px"> 
                        <label class="labelForm">Nível Menu</label>
                        <input type="number" name="nivelMenu" class="form-control" autocomplete="off">
                    </div>
            </div>
                
           
                
                <div style="text-align:right; margin-top:30px">

                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                </div>
            </form>
        </div>

    </div>

<script src="../js/input.js"></script>
</body>

</html>