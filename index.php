<?php
// lucas 09102023 novo padrao
//Gabriel 05102023 ID 575 Demandas/Comentarios - Layout de chat
include_once __DIR__ . "/../config.php";
include_once "header.php";
include_once ROOT . "/sistema/database/loginAplicativo.php";
$nivelMenuLogin = buscaLoginAplicativo($_SESSION['idLogin'], 'Services');
$configuracao = 1;
$nivelMenu = $nivelMenuLogin['nivelMenu'];

?>

<!doctype html>
<html lang="pt-BR">
<head>
    
    <?php include_once ROOT. "/vendor/head_css.php";?>
    <!-- Gabriel 05102023 ID 575 removido style, formato arquivo /excluido style -->

    <title>Serviços</title>

</head>

<body>
    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>

    <div class="d-flex">

        <?php include_once  ROOT . "/sistema/painel.php"; ?>

        <div class="container-fluid">

            <div class="row ">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0 ts-bgAplicativos">
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
                                <a class="nav-link 
                        <?php if ($tab == "dashboard") {
                                echo " active ";
                            } ?>" href="?tab=dashboard" role="tab">Dashboard</a>
                            </li>
                        <?php }

                        if ($nivelMenu >= 1) {
                        ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "agenda") {echo " active ";} ?>" 
                                href="?tab=agenda" role="tab">Agenda</a>
                            </li>

                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "execucao") {echo " active ";} ?>"
                                href="?tab=execucao" role="tab">Execução</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "demandas") {echo " active ";} ?>" 
                                href="?tab=demandas" role="tab">Demandas</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 1) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "fila") {echo " active ";} ?>" 
                                href="?tab=fila" role="tab">Fila de Atendimento</a>
                            </li>                            
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "contratos") {echo " active ";} ?>" 
                                href="?tab=contratos" role="tab">Contratos</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "projetos") {echo " active ";} ?>" 
                                href="?tab=projetos" role="tab">Projetos</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "orcamento") {echo " active ";} ?>" 
                                href="?tab=orcamento" role="tab">Orçamentos</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "os") {echo " active ";} ?>" 
                                href="?tab=os" role="tab">O.S.</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "rotinas") {echo " active ";} ?>" 
                                href="?tab=rotinas" role="tab">Rotinas</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 4) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "configuracao") {echo " active ";} ?>" 
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
                        <option value="<?php echo URLROOT ?>/services/?tab=dashboard" 
                        <?php if ($getTab == "dashboard") {echo " selected ";} ?>>Dashboard</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=agenda" 
                        <?php if ($getTab == "agenda") {echo " selected ";} ?>>Agenda</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=execucao" 
                        <?php if ($getTab == "execucao") {echo " selected ";} ?>>Execução</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=demandas" 
                        <?php if ($getTab == "demandas") {echo " selected ";} ?>>Demandas</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=contratos" 
                        <?php if ($getTab == "contratos") {echo " selected ";} ?>>Contratos</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=projetos" 
                        <?php if ($getTab == "projetos") {echo " selected ";} ?>>Projetos</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=orcamentos" 
                        <?php if ($getTab == "orcamentos") {echo " selected ";} ?>>Orçamentos</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=os" 
                        <?php if ($getTab == "os") {echo " selected ";} ?>>O.S.</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=rotinas" 
                        <?php if ($getTab == "rotinas") {echo " selected ";} ?>>Rotinas</option>

                        <option value="<?php echo URLROOT ?>/services/?tab=configuracao" 
                        <?php if ($getTab == "configuracao") {echo " selected ";} ?>>Configurações</option>
                    </select>
                </div>
             
                <?php include_once  ROOT . "/sistema/novoperfil.php"; ?>

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
            if ($tab == "orcamento") {
                $src = "orcamento/";
                $title = "Serviços/Orçamentos";
            }
            if ($tab == "os") {
                $src = "contratos/?tipo=os";
                $title = "Serviços/O.S.";
            }
            if ($tab == "rotinas") {
                $src = "contratos/?tipo=rotinas";
                $title = "Serviços/Rotinas";
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
            if ($tab == "fila") {
                $src = "visaocli/";
                $title = "Fila";
            }
            if ($tab == "configuracao") {
                $src = "configuracao/";
                $title = "Serviços/Configuração";
                if (isset($_GET['stab'])) {
                    $src = $src . "?stab=" . $_GET['stab'];
                }
            }

            if ($src !== "") { ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe" src="<?php echo URLROOT ?>/services/<?php echo $src ?>"></iframe>
                </div>
            <?php } ?>

        </div><!-- div container -->
    </div><!-- div class="d-flex" -->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT. "/vendor/footer_js.php";

    /***  helio 24.10.2023 - retirado CHAT, pois estava derrubando oservidor 
      //Gabriel 05102023 ID 575 removido chat, formato include 
    **  include "demandas/chat.php";
    ***/
    ?>

    <script src="<?php echo URLROOT ?>/sistema/js/mobileSelectTabs.js"></script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>