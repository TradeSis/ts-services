<?php
include_once __DIR__ . "/../config.php";
include_once ROOT . "/sistema/painel.php";
include_once ROOT . "/sistema/database/loginAplicativo.php";

$nivelMenuLogin = buscaLoginAplicativo($_SESSION['idLogin'], 'Services');


$configuracao = 1;

$nivelMenu = $nivelMenuLogin['nivelMenu'];



?>




<div class="container-fluid mt-1">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <ul class="nav a" id="myTabs">


                <?php
                $tab = ''; // default
                
                if (isset($_GET['tab'])) {
                    $tab = $_GET['tab'];
                }

                if ($nivelMenu >= 1) {
                    if ($tab == '') {
                        $tab = 'dashboard';
                    } ?>

                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "dashboard") {
                            echo " active ";
                        } ?>" href="?tab=dashboard" role="tab">Dashboard</a>
                    </li>
                <?php }


                if ($nivelMenu >= 1) {
                    ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "agenda") {
                            echo " active ";
                        } ?>" href="?tab=agenda" role="tab">Agenda</a>
                    </li>

                <?php }
                if ($nivelMenu >= 2) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "execucao") {
                            echo " active ";
                        } ?>" href="?tab=execucao" role="tab">Execução</a>
                    </li>
                <?php }

                if ($nivelMenu >= 1) { ?>

                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "demandas") {
                            echo " active ";
                        } ?>" href="?tab=demandas" role="tab">Demandas</a>
                    </li>

                <?php }

                if ($nivelMenu >= 2) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "contratos") {
                            echo " active ";
                        } ?>" href="?tab=contratos" role="tab">Contratos</a>
                    </li>
                <?php }

                if ($nivelMenu >= 2) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "projetos") {
                            echo " active ";
                        } ?>" href="?tab=projetos" role="tab">Projetos</a>
                    </li>
                <?php }

                if ($nivelMenu >= 2) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "os") {
                            echo " active ";
                        } ?>" href="?tab=os" role="tab">O.S.</a>
                    </li>
                <?php }



                if ($nivelMenu >= 4) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "configuracao") {
                            echo " active ";
                        } ?>" href="?tab=configuracao" role="tab" data-toggle="tooltip" data-placement="top"
                            title="Configurações"><i class="bi bi-gear"></i> Configurações</a>
                    </li>
                <?php } ?>


            </ul>


        </div>

    </div>

</div>

<?php
$src = "";
$title = "Serviços";
if ($tab == "servicos") {
    $src = "demandas/?tipo=os";

}

if ($tab == "demandas") {
    $src = "demandas/";
    $title = "Serviços/Demandas";
}
if ($tab == "atividades") {
    $src = "demandas/?tipo=projetos";
    $title = "Serviços/Atividades";
}
if ($tab == "os") {
    $src = "contratos/?tipo=os";
    $title = "Serviços/O.S.";
}

if ($tab == "contratos") {
    $src = "contratos/?tipo=contratos";
    $title = "Serviços/Contratos";
}
if ($tab == "projetos") {
    $src = "contratos/?tipo=projetos";
    $title = "Serviços/Projetos";
}
if ($tab == "execucao") {
    $src = "demandas/tarefas.php";
    $title = "Serviços/Execução";
}
if ($tab == "dashboard") {
    $src = "demandas/dashboard.php";
    $title = "Serviços/Dashboard";
}
if ($tab == "agenda") {
    $src = "demandas/agenda.php";
    $title = "Serviços/Agenda";
}
if ($tab == "configuracao") {
    $src = "configuracao/";
    $title = "Serviços/Configuração";
    if (isset($_GET['stab'])) {
        $src = $src . "?stab=" . $_GET['stab'];
    }


}

if ($src !== "") {
    //echo URLROOT ."/services/". $src;
    ?>
    </body>

    </html>

    <!DOCTYPE html>

    <head>
        <title>
            <?php echo $title; ?>
        </title>
    </head>
    <html>

    <body>

        <div class="diviFrame">
            <iframe class="iFrame container-fluid " id="iFrameTab"
                src="<?php echo URLROOT ?>/services/<?php echo $src ?>"></iframe>
        </div>
        <?php
}
?>

</body>

</html>