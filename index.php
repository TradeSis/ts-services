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
    .nav-link.active.show {
        border-bottom: 3px solid #2E59D9;
        border-radius: 3px 3px 0 0;
        color: #1B4D60;
        background-color: transparent;
    }
</style>

<div class="container-fluid mt-1">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <ul class="nav nav-pills" id="myTabs" role="tablist">
                <?php foreach ($menusAtalho as $menuAtalho) { ?>
                    <li class="nav-item">
                        <a class="nav-link" id="<?php echo $menuAtalho['progrNome'] ?>-tab" data-toggle="tab" href="#<?php echo $menuAtalho['progrNome'] ?>" data-url="<?php echo $menuAtalho['progrLink'] ?>" role="tab" aria-controls="<?php echo $menuAtalho['progrNome'] ?>" aria-selected="true" style="color:black"><?php echo $menuAtalho['progrNome'] ?></a>
                    </li>
                <?php } ?>

                <?php if ($configuracao == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" id="ConfiguracaoSistema-tab" data-toggle="tab" href="#ConfiguracaoSistema" role="tab" aria-controls="ConfiguracaoSistema" aria-selected="true" style="color:black" data-toggle="tooltip" data-placement="top" title="Configurações"><i class="bi bi-gear" style="font-size: 18px;"></i></a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="col-md-12 mt-3">
            <div class="tab-content" id="myTabContent">
                <?php foreach ($menusAtalho as $menuAtalho) { ?>

                    <div class="tab-pane fade" id="<?php echo $menuAtalho['progrNome'] ?>" role="tabpanel" aria-labelledby="<?php echo $menuAtalho['progrNome'] ?>-tab">
                        <?php //include $menuAtalho['progrLink'] ?>
                    </div>
                <?php } ?>

                <?php if ($configuracao == 1) { ?>
                    <div class="tab-pane fade" id="ConfiguracaoSistema" role="tabpanel" aria-labelledby="ConfiguracaoSistema-tab">
                        <?php include 'ConfiguracaoSistema.php' ?>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>



</div>

<script>
    
$('#myTabs a').click(function (e) {
    
	e.preventDefault();
  
	var url = $(this).attr("data-url");
    

  	var href = this.hash;
    

  	var pane = $(this);
	
	// ajax load from data-url
	$(href).load(url,function(result){      
	    pane.tab('show');
	});
});

// load first tab content
$('#home').load($('.active a').attr("data-url"),function(result){
  $('.active a').tab('show');
});

 </script>

</body>

</html>
