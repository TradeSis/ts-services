<?php
//Lucas 05042023 - adicionado foreach para menuLateral.
//gabriel 220323 11:19 - adicionado IF para usuario cliente
//Lucas 13032023 - criado versão 2 do menu.

include_once 'head.php';
include_once 'database/montaMenu.php';

$menus = buscaMenuGeral();
//echo json_encode($menus);
?>


<body>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />


    <div class="container-fluid">

        <div class="row Menu">

            <div class="col-sm-1">
                <div class="btnAbre">
                    <span class="material-symbols-outlined">menu_open</span>
                </div>
            </div>



            <div class="col-sm-1">
                <img src="img/brand/white.png" width="130">
            </div>

            <?php
                if ($_SESSION['idCliente'] == NULL) { ?>
                <nav class=" col-md navbar navbar-expand  topbar me-4 ">
                    <ul class="navbar-nav mx-auto ml-4" id="novoMenu2">
                        <li class="nav-item dropdown ">
                            <a src="contratos/" href="#" class="nav-link Menu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fs-5 text">Contratos</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a src="demandas/" href="#" class="nav-link Menu " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fs-5 text">Demandas</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a src="demandas/tarefas.php" href="#" class="nav-link Menu " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fs-5 text">Tarefas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link Menu btnCadastros" role="button">
                                <span class="fs-5 text">Cadastros</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-4" style="margin-right:30px">
                        <li class="nav-item dropdown font-weight-bold ml-4" style="color:white">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:white;">
                                <span class="fs-1 text">
                                    <?php echo $logado ?>
                                </span>
                            </a>
                            <div class="dropdown-menu mr-2" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="usuario/usuario_alterar.php?idUsuario=<?php echo $_SESSION['idUsuario'] ?>" src=""><i class="bi bi-person-circle"></i>&#32;<samp>Perfil</samp></a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                            </div>
                        </li>

                    </ul>
                </nav>
                <?php }
                if ($_SESSION['idCliente']  >= 1) { ?>
                    <nav class=" col-md navbar navbar-expand  topbar me-4 ">
                        <ul class="navbar-nav mx-auto ml-4" id="novoMenu2">
                            <li class="nav-item dropdown">
                                <a src="demandas/" href="#" class="nav-link Menu " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fs-5 text">Demandas</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-4" style="margin-right:30px">
                            <li class="nav-item dropdown font-weight-bold ml-4" style="color:white">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:white;">
                                    <span class="fs-1 text">
                                        <?php echo $logado ?>
                                    </span>
                                </a>
                                <div class="dropdown-menu mr-2" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="usuario/usuario_alterar.php?idUsuario=<?php echo $_SESSION['idUsuario'] ?>" src=""><i class="bi bi-person-circle"></i>&#32;<samp>Perfil</samp></a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                                </div>
                            </li>
    
                        </ul>
                    </nav>                            
                <?php } ?>
                 
            <!-- 
            <div class="col dropdown align-items-right mt-2 font-weight-bold"  style="text-align:right">
                <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#logoutModal">
                    <span><?php echo $logado ?></span>
                </a>

            </div> -->


        </div>
        <?php
            if ($_SESSION['idCliente'] == NULL) { ?>
            <nav id="menuLateral" class="menuLateral">
                <div class="titulo"><span></span></div>
                <ul id="novoMenu2">
                    <li><a href="#" src="contratos/">Contratos</a></li>
                    <li><a href="#" src="demandas/">Demandas</a></li>
                    <li><a href="#" src="demandas/tarefas.php">Tarefas</a></li>


                    <?php
                    $contador = 1;
                    foreach ($menus as $menu) {
                    ?>
                        <li><a href="#" class="secao<?php echo $contador ?>"><?php echo $menu['nomeMenu'] ?><span class="material-symbols-outlined seta<?php echo $contador ?>">arrow_right</span></a>
                    

                        <ul class="itensSecao<?php echo $contador ?>">
                            <?php
                            foreach ($menu['menuPrograma'] as $menuPrograma) {
                            ?>
                            <li><a href="#" src="<?php echo $menuPrograma['progrLink'] ?>"><?php echo $menuPrograma['progrNome'] ?></a></li>
                            <?php } ?>
                            
                           
                        </ul>
                    </li>
                    <?php
                    $contador = $contador + 1;
                     } ?>

                    <li>
                        <a class="logout" href="#" data-toggle="modal" data-target="#logoutModal"><span class="material-symbols-outlined">logout</span></a>
                    </li>
                </ul>
            </nav>
            <?php }
            if ($_SESSION['idCliente'] >= 1) { ?>
                <nav id="menuLateral" class="menuLateral">
                    <div class="titulo"><span></span></div>
                    <ul id="novoMenu2">
                        <li><a href="#" src="demandas/">Demandas</a></li>
    
                        <li><a href="#" class="secao2">Outros<span class="material-symbols-outlined seta2">arrow_right</span></a>
                            <ul class="itensSecao2">
                                <li><a href="#" src="http://10.2.0.44/bsweb/erp/etiqueta/normalv2.html">Etiquetas</a>
                                <li><a href="#" src="cadastros/relatorios.php">Relatórios</a>
                                <li><a href="#" src="cadastros/seguros_parametros.php">Seguros</a>
                            </ul>
                        </li>
    
                        <li>
                            <a class="logout" href="#" data-toggle="modal" data-target="#logoutModal"><span class="material-symbols-outlined">logout</span></a>
                        </li>
                    </ul>
                </nav>

            <?php } ?>

        <nav id="menusecundario" class="menusecundario">
            <div class="titulo"><span>Cadastros</span></div>
            <li>
                <ul class="itenscadastro" id="novoMenu2">
                    <li><a href="#" src="cadastros/tipostatus.php">Tipo Status</a></li>
                    <li><a href="#" src="cadastros/tipoocorrencia.php">Tipo Ocorrências</a></li>
                    <li><a href="#" src="cadastros/clientes.php">Clientes</a></li>
                    <li><a href="#" src="usuario/usuario.php">Usuarios</a></li>
                    <li><a href="#" src="cadastros/contratoStatus.php">Contrato Status</a></li>

                </ul>
            </li>
        </nav>


    </div>

    <div class="modal fade" id="logoutModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Logout" abaixo se você deseja encerrar sua sessão.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary logout" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <div class="diviFrame" style="overflow:hidden;">
        <iframe class="iFrame container-fluid " id="myIframe" src=""></iframe>
    </div>

    <?php
    //include 'footer.php';
    ?>
</body>
<script type="text/javascript" src="menu.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // SELECT MENU
        $("#novoMenu a").click(function() {

            var value = $(this).text();
            value = $(this).attr('id');

            //IFRAME TAG

            $("#myIframe").attr('src', value);
        })
        // SELECT MENU
        $("#novoMenu2 a").click(function() {

            var value = $(this).text();
            value = $(this).attr('src');

            //IFRAME TAG
            if (value) {

                $("#myIframe").attr('src', value);
                $('.menuLateral').removeClass('mostra');
                $('.menusecundario').removeClass('mostra');
                $('.diviFrame').removeClass('mostra');


            }

        })

        // SELECT MENU
        $("#menuCadastros a").click(function() {

            var value = $(this).text();
            value = $(this).attr('id');

            //IFRAME TAG
            if (value != '') {
                $("#myIframe").attr('src', value);
            }

        })


    });
</script>

</html>