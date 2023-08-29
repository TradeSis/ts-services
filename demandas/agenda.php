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
$demandas = buscaDemandasAbertas();
$tarefas = buscaTarefas();

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/services/demandas/fullcalendar.min.css">
    <script type="text/javascript" src="<?php echo URLROOT ?>/services/demandas/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/services/demandas/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo URLROOT ?>/services/demandas/pt-br.min.js"></script>
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
    </style>
</head>

</html>

<body class="bg-transparent">
    <div class="container mt-1">
        <div class="row">
            <div class="col-sm-11">
                <h3 class="text-center">Agenda - Tradesis</h3>
            </div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-warning" data-toggle="modal"
                    data-target="#agendarModal">Agendar</button>
            </div>
        </div>
    </div>
    <hr>
    <div id="calendar"></div>

    <div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsModalLabel">
                        <p id="eventID" style="margin-bottom:-20px"></p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="labelForm">Título</label>
                    <input type="text" class="data select form-control" id="eventTitle" readonly>
                    <div class="row">
                        <div class="col-md">
                            <label>Data</label>
                            <input type="text" class="data select form-control" id="eventDate" readonly>
                        </div>
                        <div class="col-md">
                            <label>Início</label>
                            <input type="text" class="data select form-control" id="eventStart" readonly>
                        </div>
                        <div class="col-md">
                            <label>Fim</label>
                            <input type="text" class="data select form-control" id="eventEnd" readonly>
                        </div>
                    </div>
                    <hr>
                    <a id="visualizarDemandaButton" class="btn btn-primary" style="float:right">Visualizar</a>
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
                                    <input type="text" class="form-control" name="tituloTarefa" autocomplete="off">
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
                                            <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?>
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
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                            ?>
                                        <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Ocorrência</label>
                                    <select class="form-control" name="idTipoOcorrencia">
                                        <option value="null"></option>
                                        <?php
                                        foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                        <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
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
                            <button type="submit" class="btn btn-info">Agendar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#calendar").fullCalendar({
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "month,agendaWeek,agendaDay,schedule"
                },
                locale: 'pt-br',
                defaultView: "month",
                navLinks: true,
                editable: false,
                eventLimit: false,
                selectable: true,
                selectHelper: false,
                views: {
                    month: {
                        timeFormat: 'HH:mm',
                    },
                    agendaWeek: {
                        minTime: "06:00:00"
                    },
                    agendaDay: {
                        minTime: "06:00:00"
                    },
                    schedule: {
                        type: 'list',
                        duration: { months: 1 },
                        buttonText: 'Programação'
                    }
                },
                events: [
                    <?php
                    $colors = array('#FF6B6B', '#77DD77', '#6CA6CD', '#FFD700', '#FF69B4', '#00CED1');
                    $colorIndex = 0;
                    foreach ($tarefas as $tarefa) {
                        $color = $colors[$colorIndex % count($colors)];
                        $colorIndex++;
                        ?>
                        {
                        _id: '<?php echo $tarefa['idTarefa']; ?>',
                        title: '<?php echo $tarefa['tituloTarefa'] . ' ' . $tarefa['tituloDemanda']; ?>',
                        start: '<?php echo $tarefa['Previsto'] . ' ' . $tarefa['horaInicioPrevisto']; ?>',
                        end: '<?php echo $tarefa['Previsto'] . ' ' . $tarefa['horaFinalPrevisto']; ?>',
                        idDemanda: '<?php echo $tarefa['idDemanda']; ?>',
                        color: '<?php echo $color; ?>'
                    },
                    <?php } ?>
                ],
                eventRender: function (event, element) {
                    element.css('font-weight', 'bold');
                },
                eventClick: function (calEvent, jsEvent, view) {
                    $("#eventID").text("Tarefa " + calEvent._id);
                    $("#eventTitle").val(calEvent.title);
                    $("#eventDate").val(moment(calEvent.start).format('DD/MM/YYYY'));
                    $("#eventStart").val(moment(calEvent.start).format('HH:mm'));
                    $("#eventEnd").val(moment(calEvent.end).format('HH:mm'));
                    if (calEvent.idDemanda !== "") {  
                        var visualizarDemandaUrl = "visualizar.php?idDemanda=" + calEvent.idDemanda;
                        $("#visualizarDemandaButton").attr("href", "javascript:void(0);");
                        $("#visualizarDemandaButton").attr("onclick", "loadPage('" + visualizarDemandaUrl + "')");
                    } else {
                        $("#visualizarDemandaButton").removeAttr("href");
                        $("#visualizarDemandaButton").removeAttr("onclick");
                    }

                    $("#eventDetailsModal").modal();
                }
            });
            $('#scheduleButton').on('click', function () {
                $('#calendar').fullCalendar('changeView', 'schedule');
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


        $("#agendarForm").submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/tarefas.php?operacao=previsao",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage,
            });
        });

        function refreshPage() {
            window.location.reload();
        }
    </script>
</body>

</html>