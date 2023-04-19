<?php
// Lucas 19042023 -  adicionado link para bootstrap.css e padraoCss.css
// Lucas 29032023 - modificado tempo da seção
// Lucas 09032023 -  linha 5, foi adicionado parametro de tempo 
// helio 26012023 16:16

session_start();

if (!isset($_SESSION['LAST_ACTIVITY']) || !isset($_SESSION['usuario'])) {
    echo "<script>top.window.location = '/ts/painel/login.php'</script>";
} 

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > ( 2 * 60 * 60  )   )) { // 60segundos * MINUTOS * HORAS
    session_unset();
    session_destroy();
    echo "<script>top.window.location = '/ts/painel/login.php'</script>";
} 

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
$logado = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html>


<head>
        <title>TS/painel</title>

                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                <script src="/ts/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="/ts/vendor/animacoes/bodymovin.js"></script>
                <script src="/ts/vendor/jquery/jquery.min.js"></script>
        <script src="/ts/vendor/jquery/jquery.mask.min.js" type="text/javascript" ></script>
                <script src="/ts/vendor/jquery/tabletojson.min.js" type="text/javascript"  ></script>
                <script src="/ts/vendor/jquery-easing/jquery.easing.min.js"></script>

        <script src="/ts/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"  ></script>
        <script src="/ts/vendor/bootstrap/bootbox/bootbox.min.js" type="text/javascript" ></script>
        <link  href="/ts/vendor/bootstrap/css/bootstrap.min.css" rel= "stylesheet" type="text/css"  >

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        <link  href="/ts/painel/css/bootstrap.css" rel= "stylesheet" type="text/css">
        <link  href="/ts/painel/css/padrao.css" rel= "stylesheet" type="text/css">
        <link  href="/ts/painel/css/menu.css" rel="stylesheet" type="text/css" >
        
        <script src="/ts/painel/js/input.js"></script>

</head>



	