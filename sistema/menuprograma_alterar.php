<?php

include_once('../head.php');
include_once('../database/menuprograma.php');



$menuProgr = buscaMenuProgramas($_GET['progrNome']);
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

                        <input type="text" name="IDMenu" class="form-control"  value="<?php echo $menuProgr['IDMenu'] ?>">
                        <label>Nome</label>
                        <input type="text" name="progrNome" class="form-control"  value="<?php echo $menuProgr['progrNome'] ?>"style="display: none">
                        <label>Aplicativo</label>
                        <input type="text" name="aplicativo" class="form-control"  value="<?php echo $menuProgr['aplicativo'] ?>">   
                        <label>link</label>
                        <input type="text" name="progrLink" class="form-control"  value="<?php echo $menuProgr['progrLink'] ?>">
                        <label>Nivel</label>
                        <input type="text" name="nivelMenu" class="form-control"  value="<?php echo $menuProgr['nivelMenu'] ?>"> 

                        
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