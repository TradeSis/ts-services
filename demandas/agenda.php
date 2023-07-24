<?php
include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/tarefas.php');
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

<body>
    <div class="container mt-1">
        <h3 class="text-center">Agenda - Tradesis</h3>
    </div>
   
    <!-- <hr> -->
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
                        title: '<?php echo $tarefa['tituloDemanda']; ?>',
                        start: '<?php echo $tarefa['Previsto'] . ' ' . $tarefa['horaInicioPrevisto']; ?>',
                        end: '<?php echo $tarefa['Previsto'] . ' ' . $tarefa['horaFinalPrevisto']; ?>',
                        idDemanda: '<?php echo $tarefa['idDemanda']; ?>',
                        color: '<?php echo $color; ?>'
                    },
                    <?php } ?>
                ],
                eventRender: function (event, element) {
                    element.css('font-weight', 'bold'); // Make event text bold
                },
                eventClick: function (calEvent, jsEvent, view) {
                    $("#eventID").text("Tarefa " + calEvent._id);
                    $("#eventTitle").val(calEvent.title);
                    $("#eventDate").val(moment(calEvent.start).format('DD/MM/YYYY'));
                    $("#eventStart").val(moment(calEvent.start).format('HH:mm'));
                    $("#eventEnd").val(moment(calEvent.end).format('HH:mm'));
                    var visualizarDemandaUrl = "visualizar.php?idDemanda=" + calEvent.idDemanda;
                    $("#visualizarDemandaButton").attr("href", "javascript:void(0);");
                    $("#visualizarDemandaButton").attr("onclick", "loadPage('" + visualizarDemandaUrl + "')");
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
    </script>
</body>

</html>