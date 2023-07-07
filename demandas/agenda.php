<?php
include_once '../head.php';
include_once '../database/tarefas.php';
$tarefas = buscaTarefas();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./fullcalendar.min.css">
    <script type="text/javascript" src="./moment.min.js"></script>
    <script type="text/javascript" src="./popper.min.js"></script>
    <script type="text/javascript" src="./fullcalendar.min.js"></script>
    <script type="text/javascript" src="./pt-br.min.js"></script>
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

        .event-data {
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-1">
        <h3 class="text-center">Agenda - Tradesis</h3>
    </div>
    </div>
    <hr>
    <div id="calendar"></div>

    <div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                    <label>Título</label>
                    <p id="eventTitle" class="event-data"></p>
                    <div class="row">
                        <div class="col-md">
                            <label>Data</label>
                            <p id="eventDate" class="event-data"></p>
                        </div>
                        <div class="col-md">
                            <label>Início</label>
                            <p id="eventStart" class="event-data"></p>
                        </div>
                        <div class="col-md">
                            <label>Fim</label>
                            <p id="eventEnd" class="event-data"></p>
                        </div>
                    </div>
                    <hr>
                    <a id="visualizarDemandaButton" class="btn btn-primary" style="float:right">Visualizar Demanda</a>
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
                    right: "month,agendaWeek,agendaDay"
                },
                locale: 'pt-br',
                defaultView: "month",
                navLinks: true,
                editable: false,
                eventLimit: false,
                selectable: true,
                selectHelper: false,
                events: [
                    <?php foreach ($tarefas as $tarefa) { ?>
                        {
                        _id: '<?php echo $tarefa['idTarefa']; ?>',
                        title: '<?php echo $tarefa['tituloDemanda']; ?>',
                        start: '<?php echo $tarefa['Previsto'] . ' ' . $tarefa['horaInicioPrevisto']; ?>',
                        end: '<?php echo $tarefa['Previsto'] . ' ' . $tarefa['horaFinalPrevisto']; ?>',
                        idDemanda: '<?php echo $tarefa['idDemanda']; ?>'
                    },
                    <?php } ?>
                ],
                eventClick: function (calEvent, jsEvent, view) {
                    $("#eventID").text("Tarefa " + calEvent._id);
                    $("#eventTitle").text(calEvent.title);
                    $("#eventDate").text(moment(calEvent.start).format('DD/MM/YYYY'));
                    $("#eventStart").text(moment(calEvent.start).format('HH:mm'));
                    $("#eventEnd").text(moment(calEvent.end).format('HH:mm'));
                    var visualizarDemandaUrl = "visualizar.php?idDemanda=" + calEvent.idDemanda;
                    $("#visualizarDemandaButton").attr("href", "javascript:void(0);");
                    $("#visualizarDemandaButton").attr("onclick", "loadPage('" + visualizarDemandaUrl + "')");
                    $("#eventDetailsModal").modal();
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
    </script>
</body>

</html>