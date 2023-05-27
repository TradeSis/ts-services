<?php
// Helio 20022023 - Demandas e Contratos, modurar para *_parametros.php como inicial
// helio 16022023 - retirado class  bg-info linha 19
// helio 01022023 alterado para include_once
// gabriel 01022023 15:06 - menu tarefas linha 36
// gabriel 31012023 16:24 - iframe
// helio 26012023 16:16

include_once 'head.php';
include_once 'conexao.php';


?>


<body>
<style rel="stylesheet" type="text/css">
      
       
        .Menu {
            background-color:#12192C;
            color:#FFF;
            
            }
            .iFrame {
  width: 100%;
  height: 551px;
  overflow: hidden;
  overflow-x: hidden;
  border: 0px solid #000;
}
      </style>

    <div class="container-fluid">

        <div class="row Menu" >
            <div class="col-md-2">
                <img src="img/brand/white.png" width="180">
            </div>


            <nav class=" col-md navbar navbar-expand  topbar me-5">
                <ul class="navbar-nav mx-auto" id="novoMenu2" >
                    <li class="nav-item dropdown " >
                        <a src="contratos/" href="#" class="nav-link Menu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
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
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle Menu" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fs-5 text">Cadastros</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" src="cadastros/tipostatus.php">Tipo Status</a>
                            <a class="dropdown-item" href="#" src="cadastros/tipoocorrencia.php">Tipo Ocorrências</a>
                            <a class="dropdown-item" href="#" src="cadastros/clientes.php">Clientes</a>
                            <a class="dropdown-item" href="#" src="usuario/usuario.php">Usuarios</a>
                            <a class="dropdown-item" href="#" src="cadastros/contratoStatus.php">Contrato Status</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle Menu" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fs-5 text">Novo Menu</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" src="http://10.2.0.44/bsweb/erp/etiqueta/normalv2.html">Etiquetas</a>
                            <a class="dropdown-item" href="#" src="cadastros/relatorios.php">Relatórios</a>
                            <a class="dropdown-item" href="#" src="cadastros/seguros_parametros.php">Seguros</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav me-5">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fs-5 text"><?php echo $logado ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                        </div>
                    </li>
                </ul>
                
            </nav>
        </div>
    </div>

    <div class="modal fade" id="logoutModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
  
    <div  style="overflow:hidden; width: 100%;">
        <iframe class="iFrame container-fluid " id="myIframe" src="" ></iframe>
    </div>

    <?php
    include 'footer.php';
    ?>
</body>

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
            if (value != '') {
                $("#myIframe").attr('src', value);
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