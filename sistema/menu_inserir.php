<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/aplicativo.php');

$aplicativos= buscaAplicativos();
?>


<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Inserir Menu</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="menu.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">

                <form action="../database/menu.php?operacao=inserir" method="post">

                    <div class="form-group" style="margin-top:10px">

                  

                        <label>Menu</label>
                        <input type="text" name="nomeMenu" class="form-control"  autocomplete="off">

                        <label>Aplicativo</label>
                        <select class="form-control" name="idAplicativo">
                            <?php
                                foreach ($aplicativos as $aplicativo) {
                            ?>
                            <option value="<?php echo $aplicativo['idAplicativo'] ?>"><?php echo $aplicativo['nomeAplicativo']  ?></option>
                            <?php  } ?>
                        </select>

                        <label>Nível Menu</label>
                        <input type="number" name="nivelMenu" class="form-control"  autocomplete="off">    
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