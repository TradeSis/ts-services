<?php
include_once(__DIR__ . '/../header.php');

include_once "../database/demanda_visaocli.php";
include_once "../database/demanda.php";
include_once '../database/contratotipos.php';
include_once(ROOT . '/cadastros/database/usuario.php');

$urlContratoTipo = null;
if (isset($_GET["tipo"])) {
  $urlContratoTipo = $_GET["tipo"];
  $contratoTipo = buscaContratoTipos($urlContratoTipo);
} else {
  $contratoTipo = buscaContratoTipos('contratos');
}

$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
$idCliente = $usuario['idCliente'];
if($idCliente == null){
    $idCliente = 1;
}
?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <style>
        body {
            background: #f1f1f1;
        }

        .board {
            min-height: 30px;
            padding: 10px;
            background: white;
            display: inline-block;
            border-radius: 3px;
            box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>


    <div class="container-fluid">
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-2 col-lg-3 order-lg-1">
                <h2 class="ts-tituloPrincipal">visao cliente</h2>
            </div>
            <div class="col-4 col-lg-1 order-lg-2"></div>
            <div class="col-6 col-lg-2 order-lg-3"></div>
            <div class="col-12 col-lg-6 order-lg-4 text-end">
                <button type="button" class="ms-4 btn btn-success ml-4" data-bs-toggle="modal" data-bs-target="#inserirkanban"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="inserirkanban" tabindex="-1" aria-labelledby="inserirkanbanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <input type="hidden" class="form-control ts-input" name="idTipoStatus" value="<?php echo $contratoTipo['idTipoStatus_fila'] ?>">
                        <input type="hidden" class="form-control ts-input" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>">
                        <input type="hidden" class="form-control ts-input" name="idContratoTipo" value="<?php echo $contratoTipo['idContratoTipo'] ?>">
                        <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $idCliente ?>">
                        
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Adicionar <?php echo $contratoTipo['nomeDemanda'] ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group">
                                <input value="<?php echo statuskanbanAtivo("tituloDemanda", $kanbanAtivo); ?>" type="text" name="tituloDemanda" class="form-control" placeholder="Adicionar cartão" autocomplete="off" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-success" type="submit" name="save-cartaoDemanda">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-5 pt-2">
            <div class="col">
                <div class="card border-left-success p-1">
                    <div class="text-xs fw-bold text-secondary border-bottom">
                        <h5>Aberto</h5>
                    </div>
                    <?php foreach (buscaDemandas(null,TIPOSTATUS_FILA, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col">
                <div class="card border-left-success p-1">
                    <div class="text-xs fw-bold text-secondary border-bottom">
                        <h5>Reaberto</h5>   
                    </div>
                
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_RETORNO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>

                </div>
            </div>

            <div class="col">
                <div class="card border-left-success p-1">
                    <div class="text-xs fw-bold text-secondary border-bottom">
                        <h5>Execução</h5>
                    </div>
               
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_FAZENDO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_PAUSADO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col">
                <div class="card border-left-success p-1">
                    <div class="text-xs fw-bold text-secondary border-bottom">
                        <h5>Devolvido</h5>
                    </div>
                 
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_AGUARDANDOSOLICITANTE, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>

                </div>
            </div>

            <div class="col">
                <div class="card border-left-success p-1">
                    <div class="text-xs fw-bold text-secondary border-bottom">
                        <h5>Entregue</h5>
                    </div>
                   
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_REALIZADO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>

                </div>
            </div>

        </div><!-- row -->


    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>

    $(document).on('click', '#kanbanCard', function() {
        window.location.href='visualizar.php?idDemanda=' + $(this).attr('data-idDemanda');
        //window.location.href='visualizar.php?idDemanda=888';
    });
    </script>
</body>

</html>