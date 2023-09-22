<?php
include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/tarefas.php');
include_once(__DIR__ . '/../database/demanda.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
include_once(ROOT . '/cadastros/database/clientes.php');
include_once(ROOT . '/cadastros/database/usuario.php');



$clientes = buscaClientes();
$atendentes = buscaAtendente();
$ocorrencias = buscaTipoOcorrencia();

$idAtendente = null;
$statusTarefa = "1"; //ABERTO

if (isset($_SESSION['filtro_agenda'])) {
    $filtroEntrada = $_SESSION['filtro_agenda'];
    $idAtendente = $filtroEntrada['idAtendente'];
    $statusTarefa = $filtroEntrada['statusTarefa'];
}
$tarefas = buscaTarefas(null, null, $idAtendente, $statusTarefa);
$demandas = buscaDemandasAbertas();
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        ::-webkit-scrollbar {
            width: 0.5em;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #000000;
        }

        ::-webkit-scrollbar {
            width: 0;
            background-color: transparent;
        }

        .fc-novo-button {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745
        }

        .filtroresponsavel {
            width: 180px;
            position: fixed;
            top: -112px;
            left: 230px;
        }

        #calendar .fc-toolbar h2 {
            font-size: 20px;
        }
    </style>
</head>

</html>

<body class="bg-transparent">

    <nav style="margin-left:230px;margin-bottom:-50px">
        <ul>
            <form action="" method="post">
                <label class="labelForm">Responsável</label>
                <select class="form-control text-center" name="idAtendente" id="FiltroAtendente"
                    style="font-size: 14px; width: 150px; height: 35px;margin-top:-4px">
                    <option value="<?php echo null ?>">
                        <?php echo "Todos" ?>
                    </option>
                    <?php
                    foreach ($atendentes as $atendente) {
                        ?>
                        <option <?php
                        if ($atendente['idUsuario'] == $idAtendente) {
                            echo "selected";
                        }
                        ?> value="<?php echo $atendente['idUsuario'] ?>">
                            <?php echo $atendente['nomeUsuario'] ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
        </ul>
    </nav>
    <div class="mt-3" id="calendar"></div>

    <!--------- MENUFILTROS --------->
    <nav id="menuFiltros" class="menuFiltros" style="margin-top:-115px">
        <div class="titulo"><span>Filtrar por:</span></div>
        <ul>
            <li class="ls-label col-sm-12 mr-1"> <!-- ABERTO/FECHADO -->
                <form class="d-flex" action="" method="post" style="text-align: right;">
                    <select class="form-control" name="statusTarefa" id="FiltroStatusTarefa"
                        style="font-size: 14px; width: 150px; height: 35px">
                        <option value="<?php echo null ?>">
                            <?php echo "Todos" ?>
                        </option>
                        <option <?php if ($statusTarefa == "1") {
                            echo "selected";
                        } ?> value="1">Aberto</option>
                        <option <?php if ($statusTarefa == "0") {
                            echo "selected";
                        } ?> value="0">Fechado</option>
                    </select>
                </form>
            </li>
        </ul>

        <div class="col-sm" style="text-align:right; color: #fff">
            <a id="limpar-button" role="button" class="btn btn-sm mb-2" style="background-color:#84bfc3;">Limpar</a>
        </div>
    </nav>


    <!--------- ALTERAR --------->
    <div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" role="dialog"
        aria-labelledby="alterarmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="alterarForm">
                        <div class="row">
                            <div class="col-md-4" style="margin-top: 10px;">
                                <div class="form-group">
                                    <label class="labelForm">Tarefa</label>
                                    <input type="text" class="data select form-control" id="titulo" name="tituloTarefa"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -10px;">
                                <div class="form-group" id="demandaContainer">
                                    <label class="labelForm">ID/Demanda Relacionada</label>
                                    <input type="text" class="data select form-control" id="tituloDemanda"
                                        style="margin-top: 18px;" autocomplete="off" readonly>
                                    <select class="form-control" name="idDemandaSelect" id="idDemandaSelect">
                                        <?php
                                        foreach ($demandas as $demanda) {
                                            ?>
                                        <option value="<?php echo $demanda['idDemanda'] ?>">
                                            <?php echo $demanda['idDemanda'] . " - " . $demanda['tituloDemanda'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="idTarefa" id="idTarefa" />
                            <input type="hidden" class="form-control" name="idDemanda" id="idDemanda" />
                            <div class="col-md-4" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label class="labelForm">Cliente</label>
                                    <input type="text" class="data select form-control" id="nomeCliente"
                                        style="margin-top: 18px;" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Reponsável</label>
                                    <select class="form-control" name="idAtendente" id="idAtendente">
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                            ?>
                                        <option value="<?php echo $atendente['idUsuario'] ?>">
                                            <?php echo $atendente['nomeUsuario'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Ocorrência</label>
                                    <select class="form-control" name="idTipoOcorrencia" id="idTipoOcorrencia">
                                        <?php
                                        foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                        <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                                            <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -14px;">
                                <div class="form-group">
                                    <label class="labelForm">Horas Cobrado</label>
                                    <input type="time" class="data select form-control" id="horaCobrado"
                                        name="horaCobrado" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" id="Previsto" name="Previsto"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" id="horaInicioPrevisto"
                                        name="horaInicioPrevisto" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" id="horaFinalPrevisto"
                                        name="horaFinalPrevisto" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button id="AtualizarButton" type="submit" class="btn btn-warning">Atualizar</button>
                            <a id="visualizarDemandaButton" class="btn btn-primary" style="float:left">Visualizar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--------- AGENDAR --------->
    <div class="modal fade bd-example-modal-lg" id="agendarModal" tabindex="-1" role="dialog"
        aria-labelledby="agendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agendar Tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="agendarForm">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                                <div class="for-group" style="margin-top: 22px;">
                                    <input type="text" class="form-control" name="tituloTarefa" autocomplete="off"
                                        required>
                                </div>
                                <input type="hidden" class="form-control" name="idDemanda" value="null">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Cliente</label>
                                    <div class="form-group" style="margin-top: 40px;">
                                        <select class="form-control" name="idCliente">
                                            <option value="null"></option>
                                            <?php
                                            foreach ($clientes as $cliente) {
                                                ?>
                                            <option value="<?php echo $cliente['idCliente'] ?>">
                                                <?php echo $cliente['nomeCliente'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Reponsável</label>
                                    <select class="form-control" name="idAtendente">
                                        <option value="<?php echo null ?>">
                                            <?php echo "Selecione" ?>
                                        </option>
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                            ?>
                                        <option <?php
                                        if ($atendente['idUsuario'] == $_SESSION['idUsuario']) {
                                            echo "selected";
                                        } ?> value="
                                            <?php echo $atendente['idUsuario'] ?>">
                                            <?php echo $atendente['nomeUsuario'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Ocorrência</label>
                                    <select class="form-control" name="idTipoOcorrencia">
                                        <option value="<?php echo null ?>">
                                            <?php echo "Selecione" ?>
                                        </option>
                                        <?php
                                        foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                        <option <?php
                                        if ($ocorrencia['ocorrenciaInicial'] == 1) {
                                            echo "selected";
                                        } ?>   value="
                                            <?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                                            <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" name="Previsto"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" name="horaInicioPrevisto"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" name="horaFinalPrevisto"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-success">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on('click', '.fc-month-button', function () {
            gravaUltimo('month');
        });
        $(document).on('click', '.fc-agendaWeek-button', function () {
            gravaUltimo('agendaWeek');
        });
        $(document).on('click', '.fc-agendaDay-button', function () {
            gravaUltimo('agendaDay');
        });
        $(document).on('click', '.fc-schedule-button', function () {
            gravaUltimo('schedule');
        });

        //Gabriel 22092023 id542 function gravaUltimo em session
        function gravaUltimo(tab) {
            $.ajax({
                type: 'POST',
                url: '../database/tarefas.php?operacao=ultimoTab', 
                data: { ultimoTab: tab }, 
                success: function(response) {
                console.log('Session variable set successfully.');
                },
                error: function(xhr, status, error) {
                console.error('An error occurred:', error);
                }
            });
        }

        $(document).ready(function () {
             //Gabriel 22092023 id542 verifica se possui $_SESSION['ultimoTab'] se não, padrão (mês)
            var vdefaultView = '<?php echo isset($_SESSION['ultimoTab']) ? $_SESSION['ultimoTab'] : 'month' ?>';
            var today = new Date();
            var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            $("#calendar").fullCalendar({

                header: {
                    left: "filtro, prev,next today",
                    center: "title",
                    right: "month,agendaWeek,agendaDay,schedule, novo"
                },
                locale: 'pt-br',
                defaultView: vdefaultView,
                navLinks: true,
                editable: true,
                eventLimit: false,
                selectable: true,
                selectHelper: false,
                views: {
                    month: {
                        timeFormat: 'HH:mm'
                    },
                    agendaWeek: {
                        minTime: "06:00:00"
                    },
                    agendaDay: {
                        minTime: "06:00:00"
                    },
                    schedule: {
                        type: 'list',
                        visibleRange: {
                            start: today,
                            end: lastDayOfMonth
                        },
                        buttonText: 'Programação'
                    }
                },
                customButtons: {
                    filtro: {
                        text: 'Filtro',
                        click: function () {
                            $('.menuFiltros').toggleClass('mostra');
                            $('.diviFrame').toggleClass('mostra');
                        }
                    },
                    novo: {
                        text: 'Novo',
                        click: function () {
                            $('#agendarModal').modal('show');
                        }
                    }
                },
                events: [
                    <?php
                    $colors = array('#FF6B6B', '#77DD77', '#6CA6CD', '#FFD700', '#FF69B4', '#00CED1');
                    $colorIndex = 0;
                    foreach ($tarefas as $tarefa) {
                        $color = $colors[$colorIndex % count($colors)];
                        $colorIndex++;

                        if ($tarefa['idDemanda'] !== null) {
                            $tituloTarefa = empty($tarefa['tituloTarefa']) ? $tarefa['tituloDemanda'] . " (" . $tarefa['nomeUsuario'] . ")" : $tarefa['tituloTarefa'];
                        } else {
                            $tituloTarefa = empty($tarefa['tituloTarefa']) ? $tarefa['tituloTarefa'] . " (" . $tarefa['nomeUsuario'] . ")" : $tarefa['tituloTarefa'];
                        }
                        $horaInicioPrevisto = is_null($tarefa['horaInicioPrevisto']) ? "06:00:00" : $tarefa['horaInicioPrevisto'];
                        $horaFinalPrevisto = is_null($tarefa['horaFinalPrevisto']) ? "24:00:00" : $tarefa['horaFinalPrevisto'];

                        ?>
                    {
                        _id: '<?php echo $tarefa['idTarefa']; ?>',
                        title: '<?php echo $tituloTarefa ?>',
                        start: '<?php echo $tarefa['Previsto'] . ' ' . $horaInicioPrevisto; ?>',
                        end: '<?php echo $tarefa['Previsto'] . ' ' . $horaFinalPrevisto; ?>',
                        idTarefa: '<?php echo $tarefa['idTarefa']; ?>',
                        tituloTarefa: '<?php echo $tarefa['tituloTarefa']; ?>',
                        idCliente: '<?php echo $tarefa['idCliente']; ?>',
                        nomeCliente: '<?php echo $tarefa['nomeCliente']; ?>',
                        idDemanda: '<?php echo $tarefa['idDemanda']; ?>',
                        tituloDemanda: '<?php echo $tarefa['tituloDemanda']; ?>',
                        idAtendente: '<?php echo $tarefa['idAtendente']; ?>',
                        nomeUsuario: '<?php echo $tarefa['nomeUsuario']; ?>',
                        idTipoOcorrencia: '<?php echo $tarefa['idTipoOcorrencia']; ?>',
                        nomeTipoOcorrencia: '<?php echo $tarefa['nomeTipoOcorrencia']; ?>',
                        Previsto: '<?php echo $tarefa['Previsto']; ?>',
                        horaInicioPrevisto: '<?php echo $tarefa['horaInicioPrevisto']; ?>',
                        horaFinalPrevisto: '<?php echo $tarefa['horaFinalPrevisto']; ?>',
                        horaCobrado: '<?php echo $tarefa['horaCobrado']; ?>',
                        color: '<?php echo $color; ?>'
                    },
                    <?php } ?>
                ],
                eventRender: function (event, element) {
                    element.css('font-weight', 'bold');
                },
                eventClick: function (calEvent, jsEvent, view) {
                    $('#idTarefa').val(calEvent.idTarefa);
                    $('#titulo').val(calEvent.tituloTarefa);
                    $('#idCliente').val(calEvent.idCliente);
                    $('#nomeCliente').val(calEvent.nomeCliente);
                    $('#idDemanda').val(calEvent.idDemanda);
                    $('#idDemandaSelect').val(calEvent.idDemanda);
                    $('#tituloDemanda').val(calEvent.idDemanda + ' - ' + calEvent.tituloDemanda);
                    $('#idAtendente').val(calEvent.idAtendente);
                    $('#nomeUsuario').val(calEvent.nomeUsuario);
                    $('#idTipoOcorrencia').val(calEvent.idTipoOcorrencia);
                    $('#nomeTipoOcorrencia').val(calEvent.nomeTipoOcorrencia);
                    $('#Previsto').val(calEvent.Previsto);
                    $('#horaInicioPrevisto').val(calEvent.horaInicioPrevisto);
                    $('#horaFinalPrevisto').val(calEvent.horaFinalPrevisto);
                    $('#dataReal').val(calEvent.dataReal);
                    $('#horaInicioReal').val(calEvent.horaInicioReal);
                    $('#horaFinalReal').val(calEvent.horaFinalReal);
                    $('#horaCobrado').val(calEvent.horaCobrado);

                    if (calEvent.idDemanda !== "") {
                        var visualizarDemandaUrl = "visualizar.php?idDemanda=" + calEvent.idDemanda;
                        $("#visualizarDemandaButton").attr("href", "javascript:void(0);");
                        $("#visualizarDemandaButton").attr("onclick", "loadPage('" + visualizarDemandaUrl + "')");
                        $('#visualizarDemandaButton').show();
                    } else {
                        $('#visualizarDemandaButton').hide();
                    }

                    if (calEvent.idDemanda !== "") {
                        $('#idDemandaSelect').hide();
                        $('#tituloDemanda').show();
                    } else {
                        $('#idDemandaSelect').show();
                        $('#tituloDemanda').hide();
                    }



                    $('#alterarmodal').modal('show');
                }
            });
        });

        function loadPage(url) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", url, false);
            xhr.send();
            if (xhr.status === 200) {
                var content = xhr.responseText;
                document.open();
                document.write(content);
                document.close();
            }
        }

        var agendarModal = document.getElementById("agendarModal");

        var agendarBtn = document.querySelector("button[data-target='#agendarModal']");

        agendarBtn.onclick = function () {
            agendarModal.style.display = "block";
        };


        window.onclick = function (event) {
            if (event.target == agendarModal) {
                agendarModal.style.display = "none";
            }
        };

        function refreshPage() {
            window.location.reload();
        }

        $('.btnAbre').click(function () {
            $('.menuFiltros').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });
    </script>

    <script>
        $(document).ready(function () {
            buscar($("#FiltroAtendente").val(), $("#FiltroStatusTarefa").val());

            $("#FiltroAtendente").change(function () {
                buscar($("#FiltroAtendente").val(), $("#FiltroStatusTarefa").val());
                window.location.reload();
            });

            $("#FiltroStatusTarefa").change(function () {
                buscar($("#FiltroAtendente").val(), $("#FiltroStatusTarefa").val());
                window.location.reload();
            });

            function buscar(idAtendente, statusTarefa) {
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: '../database/tarefas.php?operacao=filtroAgenda',
                    beforeSend: function () {
                        $("#dados").html("Carregando...");
                    },
                    data: {
                        idAtendente: idAtendente,
                        statusTarefa: statusTarefa
                    },
                    success: function (data) {
                        $("#dados").html(data);
                    },
                    error: function (e) {
                        alert('Erro: ' + JSON.stringify(e));
                    }
                });
            }

            $("#limpar-button").click(function () {
                buscar(null, null);
                window.location.reload();
            });
        });

        $(document).ready(function () {
            $("#agendarForm").submit(function () {
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/tarefas.php?operacao=inserir",
                    type: 'POST',
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (msg) {
                        if (msg.retorno == "ok") {
                            window.location.reload();
                        }
                    }
                });
            });

            $("#alterarForm").submit(function () {
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/tarefas.php?operacao=alterar",
                    type: 'POST',
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (msg) {
                        if (msg.retorno == "ok") {
                            window.location.reload();
                        }
                    }
                });
            });
            function refreshPage() {
                window.location.reload();
            }
        });

    </script>
</body>

</html>