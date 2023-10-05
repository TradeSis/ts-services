<?php
include_once __DIR__ . "/../config.php";
include_once "novohead.php";
include_once ROOT . "/sistema/database/loginAplicativo.php";
$nivelMenuLogin = buscaLoginAplicativo($_SESSION['idLogin'], 'Services');
$configuracao = 1;
$nivelMenu = $nivelMenuLogin['nivelMenu'];

?>

<body>
    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>
    <div class="d-flex">
        <?php include_once  ROOT . "/sistema/novopainel.php"; ?>
        <div class="container-fluid">

            <div class="row ">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0" style="background-color: #13216A;">
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
                                <a class="nav-link1 nav-link 
                        <?php if ($tab == "dashboard") {
                                echo " active ";
                            } ?>" href="?tab=dashboard" role="tab">Dashboard</a>
                            </li>
                        <?php }

                        if ($nivelMenu >= 1) {
                        ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "agenda") {echo " active ";} ?>" 
                                href="?tab=agenda" role="tab">Agenda</a>
                            </li>

                        <?php }
                        if ($nivelMenu >= 1) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "execucao") {echo " active ";} ?>"
                                href="?tab=execucao" role="tab">Execução</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 1) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "demandas") {echo " active ";} ?>" 
                                href="?tab=demandas" role="tab">Demandas</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "contratos") {echo " active ";} ?>" 
                                href="?tab=contratos" role="tab">Contratos</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "projetos") {echo " active ";} ?>" 
                                href="?tab=projetos" role="tab">Projetos</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "os") {echo " active ";} ?>" 
                                href="?tab=os" role="tab">O.S.</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 4) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link1 nav-link <?php if ($tab == "configuracao") {echo " active ";} ?>" 
                                href="?tab=configuracao" role="tab" data-toggle="tooltip" data-placement="top" title="Configurações"><i class="bi bi-gear"></i> Configurações</a>
                            </li>
                        <?php } ?>


                    </ul>
                </div>
                <!--Essa coluna só vai aparecer em dispositivo mobile-->
                <div class="col-7 col-md-9 d-md-block d-lg-none" style="background-color: #13216A;">
                    <!--atraves do GET testa o valor para selecionar um option no select-->
                    <?php if (isset($_GET['tab'])) {
                        $getTab = $_GET['tab'];
                    } else {
                        $getTab = '';
                    } ?>
                    <select class="form-select mt-2" id="subtabServices" style="color:#000; width:160px;text-align:center; ">
                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=dashboard" 
                        <?php if ($getTab == "dashboard") {echo " selected ";} ?>>Dashboard</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=agenda" 
                        <?php if ($getTab == "agenda") {echo " selected ";} ?>>Agenda</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=execucao" 
                        <?php if ($getTab == "execucao") {echo " selected ";} ?>>Execução</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=demandas" 
                        <?php if ($getTab == "demandas") {echo " selected ";} ?>>Demandas</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=contratos" 
                        <?php if ($getTab == "contratos") {echo " selected ";} ?>>Contratos</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=projetos" 
                        <?php if ($getTab == "projetos") {echo " selected ";} ?>>Projetos</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=os" 
                        <?php if ($getTab == "os") {echo " selected ";} ?>>O.S.</option>

                        <option value="<?php echo URLROOT ?>/services/novoindex.php?tab=configuracao" 
                        <?php if ($getTab == "configuracao") {echo " selected ";} ?>>Configurações</option>
                    </select>
                </div>
                <div class="col-5 col-md-3 col-lg-2 " style="text-align:right;background-color: #13216A;">
                    <button class="btn text-white  dropdown-toggle position-relative mt-2 mr-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>&#32;Lucas
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            99+
                            <span class="visually-hidden">unread messages</span>
                    </button>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item" href="#">Mensagens</a>
                        <a class="dropdown-item" href="#">Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Logout</a>
                    </ul>
                </div>

            </div><!--row-->


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

            if ($src !== "") { ?>
                <div class="container-fluid p-0 m-0" style="overflow: hidden;">
                    <iframe class="row p-0 m-0" id="iFrameTab" style="width: 100%; height: 86vh; border:none" src="<?php echo URLROOT ?>/services/<?php echo $src ?>"></iframe>
                </div>
            <?php } ?>

        </div><!-- div container -->
    </div><!-- div class="d-flex" -->
    <?php include_once ROOT . "/sistema/footer_js.php"; ?>

    <script src="<?php echo URLROOT ?>/sistema/js/mobileSelectTabs.js"></script>

</body>

</html>