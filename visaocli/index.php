<?php
include_once(__DIR__ . '/../header.php');

include_once "../database/tipostatus.php";
include_once "../database/demanda.php";
include_once '../database/contratotipos.php';
include_once(ROOT . '/cadastros/database/usuario.php');
include_once(ROOT . '/cadastros/database/clientes.php');

$urlContratoTipo = null;
if (isset($_GET["tipo"])) {
    $urlContratoTipo = $_GET["tipo"];
    $contratoTipo = buscaContratoTipos($urlContratoTipo);
} else {
    $contratoTipo = buscaContratoTipos('contratos');
}

$usuario = buscaUsuarios(null, $_SESSION['idLogin']);
//echo json_encode(buscaDemandas(null, TIPOSTATUS_FILA, null, $usuario['idUsuario']))."<HR>";
if ($usuario["idCliente"] == null) {
    $clientes = buscaClientes($usuario["idCliente"]);
  } else {
    $clientes = array(buscaClientes($usuario["idCliente"]));
  }
?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- NOVO QUILL -->
    <link href="http://localhost/vendor/quilljs/quill.snow.css" rel="stylesheet">
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
            font-size: 13px;
        }

        .ts-kanban {
            width: 100%;
            height: 90vh;
            overflow-y: scroll;
            overflow-x: auto;
        }

        .ts-kanbanTitulo {
            position: sticky;
            top: -8px;
            background-color: #fff;
            padding: 3px;
            z-index: 2;
        }

        .ts-cardAtrasado{
            background-color: rgba(234, 64, 36, 0.7);
           /*  border: 1px solid red!important; */
        }

        .ts-cardDataPrevisao{
            font-size: 12px;
            float: right;
        }
    </style>


    <div class="container-fluid ">
        <div class="row d-flex align-items-center justify-content-center pt-1 ">

            <div class="col-6 col-md-6">
                <h2 class="ts-tituloPrincipal">Fila de Atendimento</h2>
            </div>
            
            <div class="col-6 col-md-6 text-end">
                <button type="button" class="ms-4 btn btn-success ml-4" data-bs-toggle="modal" data-bs-target="#inserirDemandaCliente"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>

        </div>

        <?php include_once 'kanban.php' ?>
        
        <!-- Modal Inserir -->
        <?php include_once 'modalDemanda_inserir.php' ?>

        <div class="row row-cols-1 row-cols-md-5 pt-2 ts-kanban">
            <div class="col ps-1 pe-1">
                <div class="card p-1">
                    <div class="card-header ts-kanbanTitulo">
                        <?php $buscaTipoStatus = buscaTipoStatus(null, TIPOSTATUS_FILA) ?>
                        <h6><?php echo $buscaTipoStatus['nomeTipoStatus']; ?></h6>
                    </div>
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_RESPONDIDO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_FILA, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_AGENDADO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>

                </div>
            </div>

            <div class="col px-1">
                <div class="card p-1">
                    <div class="card-header ts-kanbanTitulo">
                        <?php $buscaTipoStatus = buscaTipoStatus(null, TIPOSTATUS_RETORNO) ?>
                        <h6><?php echo $buscaTipoStatus['nomeTipoStatus']; ?></h6>
                    </div>

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_RETORNO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col px-1">
                <div class="card p-1">
                    <div class="card-header ts-kanbanTitulo">
                        <?php $buscaTipoStatus = buscaTipoStatus(null, TIPOSTATUS_FAZENDO) ?>
                        <h6><?php echo $buscaTipoStatus['nomeTipoStatus']; ?></h6>
                    </div>

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_FAZENDO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_PAUSADO, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col px-1">
                <div class="card p-1">
                    <div class="card-header ts-kanbanTitulo">
                        <?php $buscaTipoStatus = buscaTipoStatus(null, TIPOSTATUS_AGUARDANDOSOLICITANTE) ?>
                        <h6><?php echo $buscaTipoStatus['nomeTipoStatus']; ?></h6>
                    </div>

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_AGUARDANDOSOLICITANTE, null, $usuario['idUsuario']) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                </div>
            </div>


            <div class="col ps-1 pe-1">
                <div class="card p-1">
                    <div class="card-header ts-kanbanTitulo">
                        <?php $buscaTipoStatus = buscaTipoStatus(null, TIPOSTATUS_REALIZADO) ?>
                        <h6><?php echo $buscaTipoStatus['nomeTipoStatus']; ?></h6>
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
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- NOVO QUILL -->
    <script src="http://localhost/vendor/quilljs/quill.min.js"></script>

    <script>
        $(document).on('click', '#kanbanCard', function() {
            window.location.href = 'visualizar.php?idDemanda=' + $(this).attr('data-idDemanda');
        });

        var descricaoCliente = new Quill('.quill-descricaocliente', {
            theme: 'snow',
            modules: {
                toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
             
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
               
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['link', 'image'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
               
                [{
                    'align': []
                }],
            ]
            }
        });

        descricaoCliente.on('text-change', function(delta, oldDelta, source) {
            $('#quill-descricaocliente').val(descricaoCliente.container.firstChild.innerHTML);
        });
    </script>
</body>

</html>