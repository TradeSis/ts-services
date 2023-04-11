<?php
//Lucas 05042023 - adicionado foreach para menuLateral.
//gabriel 220323 11:19 - adicionado IF para usuario cliente
//Lucas 13032023 - criado versão 2 do menu.

include_once 'head.php';

?>

<link rel="stylesheet" href="css/painel.css">
<body>


<nav class="navbar Menu pt-2 pb-2">
  <a class="navbar-brand"></a>
        
        <ul class="navbar-nav" style="margin-right:110px; margin-bottom: 50px">
            <li class="nav-item dropdown font-weight-bold" style="color:white; position: fixed;">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:white;">
                        <span>
                                <?php echo $logado ?>
                        </span>
                    </a>
                    
                <div class="dropdown-menu" aria-labelledby="userDropdown" style="margin-left:-60px;">
                    <a class="dropdown-item" href="usuario/usuario_alterar.php?idUsuario=<?php echo $_SESSION['idUsuario'] ?>" src=""><i class="bi bi-person-circle"></i>&#32;<samp>Perfil</samp></a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
    
        </ul>
</nav>


<div class="container-fluid mt-3">

    <h1 class="heading"><a href="#"><img src="img/brand/blue.png" width="300"></a></h1>

<?php
   if ($_SESSION['idCliente'] == NULL) { ?>
    <div class="box-container mt-3">

        <div class="box">
            <img src="image/icon-1.png" alt="">
            <h3>Services</h3>
            
            <a href="index.php" class="btn">acessar</a>
        </div>

        <div class="box">
            <img src="image/icon-2.png" alt="">
            <h3>Lojas</h3>
            
            <a href="http://localhost/ts/lojas/" class="btn">acessar</a>
        </div>

        

        <div class="box">
            <img src="image/icon-2.png" alt="">
            <h3>Outros</h3>
            
            <a href="#" class="btn">acessar</a>
        </div>
        <div class="box">
            <img src="image/icon-2.png" alt="">
            <h3>Outros</h3>
            
            <a href="#" class="btn">acessar</a>
        </div>
        <div class="box">
            <img src="image/icon-2.png" alt="">
            <h3>Outros</h3>
            
            <a href="#" class="btn">acessar</a>
        </div>

    </div>
<?php }
if ($_SESSION['idCliente']  == 1) { ?>

<div class="box-container mt-3">

        <div class="box">
            <img src="image/icon-1.png" alt="">
            <h3>Services</h3>
            
            <a href="index.php" class="btn">acessar</a>
        </div>

    </div>


<?php }
if ($_SESSION['idCliente']  == 10) { ?>

<div class="box-container mt-3">

        <div class="box">
            <img src="image/icon-1.png" alt="">
            <h3>Lojas</h3>
            
            <a href="http://localhost/ts/lojas/" class="btn">acessar</a>
        </div>

    </div>
<?php } ?>



</div>

</body>

</html>