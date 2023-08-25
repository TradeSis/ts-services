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
                        $tab = 'agenda';
                    } ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "agenda") {
                            echo " active ";
                        } ?>" href="?tab=agenda"
                            role="tab">Agenda</a>
                    </li>

                <?php }
                if ($nivelMenu >= 1) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "tarefas") {
                            echo " active ";
                        } ?>" href="?tab=tarefas"
                            role="tab">Tarefas</a>
                    </li>

                <?php }
                if ($nivelMenu >= 1) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "demandas") {
                            echo " active ";
                        } ?>" href="?tab=demandas"
                            role="tab">Demandas</a>
                    </li>

                <?php }

                if ($nivelMenu >= 1) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "contratos") {
                            echo " active ";
                        } ?>"
                            href="?tab=contratos" role="tab">Contratos</a>
                    </li>
                <?php }
                if ($nivelMenu >= 1) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "atividades") {
                            echo " active ";
                        } ?>" href="?tab=atividades"
                            role="tab">Atividades</a>
                    </li>

                <?php }

                if ($nivelMenu >= 1) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "projetos") {
                            echo " active ";
                        } ?>"
                            href="?tab=projetos" role="tab">Projetos</a>
                    </li>
                <?php }
                if ($nivelMenu >= 1) {?>
                    
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "dashboard") {
                            echo " active ";
                        } ?>"
                            href="?tab=dashboard" role="tab">Dashboard</a>
                    </li>
                <?php }
              
                if ($nivelMenu >= 4) { ?>
                    <li class="nav-item mr-1">
                        <a class="nav-link1 nav-link <?php if ($tab == "configuracao") {
                            echo " active ";
                        } ?>"
                            href="?tab=configuracao" role="tab" data-toggle="tooltip" data-placement="top"
                            title="Configurações"><i class="bi bi-gear"></i> Configurações</a>
                    </li>
                <?php } ?>


            </ul>


        </div>

    </div>

</div>

<?php
$src = "";

if ($tab == "demandas") {
    $src = "demandas/?tipo=contratos";
}
if ($tab == "atividades") {
    $src = "demandas/?tipo=projetos";
}
if ($tab == "contratos") {
    $src = "contratos/?tipo=contratos";
}
if ($tab == "projetos") {
    $src = "contratos/?tipo=projetos";
}
if ($tab == "tarefas") {
    $src = "demandas/tarefas.php";
}
if ($tab == "dashboard") {
    $src = "demandas/dashboard.php";
}
if ($tab == "agenda") {
    $src = "demandas/agenda.php";
}
if ($tab == "configuracao") {
    $src = "configuracao/";
    if (isset($_GET['stab'])) {
        $src = $src . "?stab=" . $_GET['stab'];
    }


}

if ($src !== "") {
    //echo URLROOT ."/services/". $src;
    ?>
    <div class="diviFrame">
        <iframe class="iFrame container-fluid " id="iFrameTab"
            src="<?php echo URLROOT ?>/services/<?php echo $src ?>"></iframe>
    </div>
    <?php
}
?>

</body>

</html>