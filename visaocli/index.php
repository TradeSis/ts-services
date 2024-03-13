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

if(isset($_GET["idContratoTipo"]) && $_GET["idContratoTipo"] != "null"){
    $idContratoTipo = $_GET["idContratoTipo"];
}elseif(isset($_GET["idContratoTipo"]) && $_GET["idContratoTipo"] == "null"){
    $idContratoTipo = null;
}else{
    $idContratoTipo = null;
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

        .ts-cardAtrasado {
            background-color: rgba(234, 64, 36, 0.7);
            /*  border: 1px solid red!important; */
        }

        .ts-cardDataPrevisao {
            font-size: 12px;
            float: right;
        }
    </style>


    <div class="container-fluid ">
        <div class="row d-flex align-items-center justify-content-center pt-1 ">

            <div class="col-2 col-md-2">
                <h2 class="ts-tituloPrincipal">Fila de Atendimento</h2>
            </div>

            <div class="col-2 col-md-2">
                <form class="form-inline left" method="GET">
                    <div class="form-group">
                        <label class="form-label ts-label">Tipo Contrato</label>
                        <select class="form-select ts-input" name="idContratoTipo" class="form-control" onchange="this.form.submit()">
                            
                            <option <?php
                                        if ($idContratoTipo == $idContratoTipo) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $idContratoTipo ?>"><?php if($idContratoTipo == ""){echo "Todos";}else{echo $idContratoTipo;} ?></option>
                            <hr>
                            <option value="null">Todos</option>
                            <option value="contratos">Contrato</option>
                            <option value="os">O.S.</option>
                            <option value="projetos">Projeto</option>
                            <option value="rotinas">Rotina</option>
                        </select>
                    </div>
                </form>
            </div>



            <div class="col-8 col-md-8 text-end">
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
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_RESPONDIDO, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_FILA, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_AGENDADO, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
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

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_RETORNO, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
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

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_FAZENDO, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
                        <?php echo montaKanban($kanbanDemanda); ?>
                    <?php endforeach; ?>
                    <?php foreach (buscaDemandas(null, TIPOSTATUS_PAUSADO, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
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

                    <?php foreach (buscaDemandas(null, TIPOSTATUS_AGUARDANDOSOLICITANTE, null, $usuario['idUsuario'], $usuario["idCliente"], $idContratoTipo) as $kanbanDemanda) : ?>
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

    <script>
        $(document).on('click', '#kanbanCard', function() {
            window.location.href = 'visualizar.php?idDemanda=' + $(this).attr('data-idDemanda');
        });
    </script>
</body>

</html>