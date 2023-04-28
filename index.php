<?php
//Lucas 14042023 - modificado estrutura da navbar
//Lucas 05042023 - adicionado foreach para menuLateral.
//gabriel 220323 11:19 - adicionado IF para usuario cliente
//Lucas 13032023 - criado versão 2 do menu.

include_once 'head.php';
include_once 'database/montaMenu.php';

$menus = buscaMontaMenu('Services',$_SESSION['idUsuario']);
//echo json_encode($menus);
?>

<body>
    

    <nav class="Menu navbar navbar-expand topbar static-top shadow">


        <div class="hamburgerAbre mr-4">
            <span class="material-symbols-outlined">menu_open</span>
        </div>

        <a href="/ts/painel" class="logo"><img src="../img/brand/white.png" width="150"></a>

        <?php
        if ($_SESSION['idCliente'] == NULL) { ?>
            <div class=" col-md navbar navbar-expand navbar1">
                <ul class="navbar-nav mx-auto ml-4" id="novoMenu2">
                    <li>
                        <a src="contratos/" href="#" class="nav-link" role="button">
                            <span class="fs-5 text">Contratos</span>
                        </a>
                    </li>
                    <li>
                        <a src="demandas/" href="#" class="nav-link" role="button">
                            <span class="fs-5 text">Demandas</span>
                        </a>
                    </li>
                    <li>
                        <a src="demandas/tarefas.php" href="#" class="nav-link" role="button">
                            <span class="fs-5 text">Tarefas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link  btnCadastros" role="button">
                            <span class="fs-5 text">Cadastros</span>
                        </a>
                    </li>
                </ul>

            </div>
        <?php }
        if ($_SESSION['idCliente']  >= 1) { ?>
            <ul class="navbar-nav mx-auto ml-4" id="novoMenu2">

                <li>
                    <a src="demandas/" href="#" class="nav-link" role="button">
                        <span class="fs-5 text">Demandas</span>
                    </a>
                </li>

            </ul>
        <?php } ?>
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ">

            <!-- Email -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-envelope-exclamation-fill"></i>

                    <span class="badge badge-danger badge-counter"></span>
                </a>

                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Emails Recebidos
                    </h6>

                    <a class="dropdown-item text-center small text-gray-500" href="#">Ver todas as mensagens</a>
                </div>
            </li>

            <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <img class="img-profile rounded-circle" src="../imgs/undraw_profile.svg"> -->
                    <!--  <i class="bi bi-person-circle"></i>&#32; -->
                    <span class="fs-1 text"><?php echo $logado ?></span>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="usuario/usuario_alterar.php?idUsuario=<?php echo $_SESSION['idUsuario'] ?>">
                        <i class="bi bi-person-circle"></i>&#32;
                        Perfil
                    </a>
                    <a class="dropdown-item" href="/ts/painel/">
                        <i class="bi bi-display"></i>&#32;
                        Painel
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="bi bi-box-arrow-right"></i>&#32;
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>

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
                    // echo $contador;
                } ?>
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

    <!-- Modal sair -->
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
                    <a class="btn btn-primary logout" href="/ts/painel/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="diviFrame" style="overflow:hidden;">
        <iframe class="iFrame container-fluid " id="myIframe" src=""></iframe>
    </div>
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
</body>

</html>