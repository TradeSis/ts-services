<?php
include_once __DIR__ . "/../config.php";
include_once ROOT . "/painel/index.php";
include_once ROOT . "/sistema/database/montaMenu.php";
$montamenu = buscaMontaMenu('Services', $_SESSION['idUsuario']);
//echo json_encode($montamenu);

$menus = $montamenu['menu'];
if (!empty($montamenu['menuAtalho'])) {
    $menusAtalho = $montamenu['menuAtalho'];
}
if (!empty($montamenu['menuHeader'])) {
    $menuHeader = $montamenu['menuHeader'][0];
}
//echo json_encode($menusAtalho);
$configuracao = 1; // configurações poderia ficaria no lugar menuHeader
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
                $tab = '';

                if (isset($_GET['tab'])) {$tab = $_GET['tab'];}

                //$tab=$_REQUEST['tab'];
                ?>    
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="demandas") {echo " active ";} ?>" 
                        href="?tab=demandas" 
                        role="tab"                        
                        style="color:black">Demandas</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="contratos") {echo " active ";} ?>" 
                        href="?tab=contratos" 
                        role="tab"                        
                        style="color:black">Contratos</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="tarefas") {echo " active ";} ?>" 
                        href="?tab=tarefas" 
                        role="tab"                        
                        style="color:black">Tarefas</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="agenda") {echo " active ";} ?>" 
                        href="?tab=agenda" 
                        role="tab"                        
                        style="color:black">Agenda</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php if ($tab=="configuracao") {echo " active ";} ?>" 
                        href="?tab=configuracao" 
                        role="tab"                        
                        style="color:black">Configuracao</a>
                </li>


                           
            </ul>

            <!-- assuming you are putting the content of the page here -->




        </div>

    </div>

</div>

<?php
    $src="";

    if ($tab=="demandas") {$src="demandas/";}
    if ($tab=="contratos") {$src="contratos/";}
    if ($tab=="tarefas") {$src="demandas/tarefas.php";}
    if ($tab=="agenda") {$src="demandas/agenda.php";}
    if ($tab=="configuracao") {
            $src="configuracao/";
            if (isset($_GET['stab'])) {
                $src = $src . "?stab=".$_GET['stab'];
            }

            
    }
    
if ($src!=="") {
    echo URLROOT ."/services/". $src;
?>
    <div class="" style="overflow:hidden;">
        <iframe class="iFrame container-fluid " id="iFrameTab" src="<?php echo URLROOT ?>/services/<?php echo $src ?>"></iframe>
    </div>
<?php
}
?>

</body>

</html>