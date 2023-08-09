<?php
include_once __DIR__ . "/../config.php";
include_once ROOT . "/sistema/painel.php";
include_once ROOT . "/sistema/database/usuarioAplicativo.php";

$nivelMenuUsuario =  buscaUsuarioAplicativo($_SESSION['idUsuario'],'2'); //Services


$configuracao = 1; 

$nivelMenu   =  $nivelMenuUsuario['nivelMenu'];



?>

<style>
    .nav-link.active {
        border-bottom: 3px solid #2E59D9;
        border-radius: 3px 3px 0 0;
        color: #1B4D60;
        background-color: transparent;
    }
</style>

<div class="container-fluid mt-1">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <ul class="nav a" id="myTabs">


                <?php
                    $tab = 'dashboard'; // default

                    if (isset($_GET['tab'])) {$tab = $_GET['tab'];}
               
                ?>    


            <?php if ($nivelMenu>=3) { ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="dashboard") {echo " active ";} ?>" 
                        href="?tab=dashboard" 
                        role="tab"                        
                        style="color:black">Dashboard</a>
                </li>
            <?php } if ($nivelMenu>=3) { ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="tarefas") {echo " active ";} ?>" 
                        href="?tab=tarefas" 
                        role="tab"                        
                        style="color:black">Tarefas</a>
                </li>
            
            <?php } if ($nivelMenu>=3) { ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="demandas") {echo " active ";} ?>" 
                        href="?tab=demandas" 
                        role="tab"                        
                        style="color:black">Demandas</a>
                </li>
                
            <?php } if ($nivelMenu>=3) { ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="contratos") {echo " active ";} ?>" 
                        href="?tab=contratos" 
                        role="tab"                        
                        style="color:black">Contratos</a>
                </li>
            <?php } if ($nivelMenu>=3) { ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="agenda") {echo " active ";} ?>" 
                        href="?tab=agenda" 
                        role="tab"                        
                        style="color:black">Agenda</a>
                </li>
            <?php } if ($nivelMenu>=4) { ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="configuracao") {echo " active ";} ?>" 
                        href="?tab=configuracao" 
                        role="tab"                        
                        data-toggle="tooltip" data-placement="top" title="Configurações"                   
                        style="color:black"><i class="bi bi-gear" style="font-size: 18px;"></i></a>
                </li>
            <?php } ?>

                           
            </ul>


        </div>

    </div>

</div>

<?php
    $src="";

    if ($tab=="demandas") {$src="demandas/";}
    if ($tab=="contratos") {$src="contratos/";}
    if ($tab=="tarefas") {$src="demandas/tarefas.php";}
    if ($tab=="dashboard") {$src="demandas/dashboard.php";}
    if ($tab=="agenda") {$src="demandas/agenda.php";}
    if ($tab=="configuracao") {
            $src="configuracao/";
            if (isset($_GET['stab'])) {
                $src = $src . "?stab=".$_GET['stab'];
            }

            
    }
    
if ($src!=="") {
    //echo URLROOT ."/services/". $src;
?>
    <div class="diviFrame" style="overflow:hidden; height: 85vh">
        <iframe class="iFrame container-fluid " id="iFrameTab" src="<?php echo URLROOT ?>/services/<?php echo $src ?>"></iframe>
    </div>
<?php
}
?>

</body>

</html>