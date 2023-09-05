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

$filtroAgenda= ($_SESSION['filtro_agenda']);
$tarefas = buscaTarefas(null,null,$filtroAgenda['idAtendente']);
$demandas = buscaDemandasAbertas();

$idAtendente = $_SESSION['idLogin'];
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
    </style>
</head>

</html>

<body class="bg-transparent">

    <div class="container-fluid text-center mt-4">
        <div class="row">
            <div class=" btnAbre">
                <span style="font-size: 25px;font-family: 'Material Symbols Outlined'!important;" class="material-symbols-outlined">
                    filter_alt
                </span>

            </div>

            <div class="col-sm-10 text-center">
                <h3>Agenda</h3>
            </div>

            <div class="col-sm" style="text-align:right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#agendarModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>
        </div>
        <hr>
        <div id="calendar"></div>
    </div>


    <!--------- ALTERAR --------->
    <div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" role="dialog" aria-labelledby="alterarmodalLabel" aria-hidden="true">
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
                                    <input type="text" class="data select form-control" id="titulo" name="tituloTarefa" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -10px;">
                                <div class="form-group" id="demandaContainer">
                                    <label class="labelForm">ID/Demanda Relacionada</label>
                                    <input type="text" class="data select form-control" id="tituloDemanda" style="margin-top: 18px;" autocomplete="off" readonly>
                                    <select class="form-control" name="idDemandaSelect" id="idDemandaSelect">
                                        <?php
                                        foreach ($demandas as $demanda) {
                                        ?>
                                            <option value="<?php echo $demanda['idDemanda'] ?>"><?php echo $demanda['idDemanda'] . " - " . $demanda['tituloDemanda'] ?>
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
                                    <input type="text" class="data select form-control" id="nomeCliente" style="margin-top: 18px;" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Reponsável</label>
                                    <select class="form-control" name="idAtendente" id="idAtendente">
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                        ?>
                                            <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?>
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
                                                <?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -14px;">
                                <div class="form-group">
                                    <label class="labelForm">Horas Cobrado</label>
                                    <input type="time" class="data select form-control" id="horaCobrado" name="horaCobrado" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" id="Previsto" name="Previsto" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" id="horaInicioPrevisto" name="horaInicioPrevisto" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: -30px;">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" id="horaFinalPrevisto" name="horaFinalPrevisto" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-warning">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--------- AGENDAR --------->
    <div class="modal fade bd-example-modal-lg" id="agendarModal" tabindex="-1" role="dialog" aria-labelledby="agendarModalLabel" aria-hidden="true">
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
                                    <input type="text" class="form-control" name="tituloTarefa" autocomplete="off" required>
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
                                        <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                        <?php
                                        foreach ($atendentes as $atendente) {
                                        ?>
                                            <option <?php
                                                    if ($atendente['idLogin'] == $idAtendente) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class='control-label' for='inputNormal'>Ocorrência</label>
                                    <select class="form-control" name="idTipoOcorrencia">
                                        <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                        <?php
                                        foreach ($ocorrencias as $ocorrencia) {
                                        ?>
                                            <option <?php
                                                    if ($ocorrencia['ocorrenciaInicial'] == 1) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" name="Previsto" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" name="horaInicioPrevisto" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" name="horaFinalPrevisto" autocomplete="off">
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

    <!--------- MENUFILTROS --------->
    <nav id="menuFiltros" class="menuFiltros">
        <div class="titulo"><span>Filtrar por:</span></div>
        <ul>

            <li class="col-sm-12">
                <form class="d-flex" action="" method="post" style="text-align: right;">

                    <select class="form-control" name="idUsuario" id="FiltroAtendente" style="font-size: 14px; width: 150px; height: 35px" onchange="atualizarAgenda()">
                        <option value="<?php echo null ?>"><?php echo "Responsavel"  ?></option>
                        <?php
                        foreach ($atendentes as $atendente) {
                        ?>
                            <option value="<?php echo $atendente['idUsuario'] ?>" ><?php echo $atendente['nomeUsuario']  ?></option>
                        <?php  } ?>
                    </select>


                </form>
            </li>

        </ul>

        <div class="col-sm" style="text-align:right; color: #fff">
            <a onClick="limpar()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
        </div>
    </nav>

    
    <script type="text/javascript">
        $(document).ready(function() {
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
                        duration: {
                            months: 1
                        },
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

                        if ($tarefa['horaInicioPrevisto'] == null) {
                            $horaInicioPrevisto = "06:00:00";
                        } else {
                            $horaInicioPrevisto = $tarefa['horaInicioPrevisto'];
                        }
                        if ($tarefa['horaFinalPrevisto'] == null) {
                            $horaFinalPrevisto = "24:00:00";
                        } else {
                            $horaFinalPrevisto = $tarefa['horaFinalPrevisto'];
                        }
                    ?>
                        {
                            _id: '<?php echo $tarefa['idTarefa']; ?>',
                            title: '<?php echo $tarefa['tituloTarefa'] . ' ' . $tarefa['tituloDemanda']; ?>',
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
                eventRender: function(event, element) {
                    element.css('font-weight', 'bold');
                },
                eventClick: function(calEvent, jsEvent, view) {
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
                        $('#idDemandaSelect').hide();
                        $('#tituloDemanda').show();
                    } else {
                        $('#idDemandaSelect').show();
                        $('#tituloDemanda').hide();
                    }



                    $('#alterarmodal').modal('show');
                }
            });
            $('#scheduleButton').on('click', function() {
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

        agendarBtn.onclick = function() {
            agendarModal.style.display = "block";
        };


        window.onclick = function(event) {
            if (event.target == agendarModal) {
                agendarModal.style.display = "none";
            }
        };


        $("#agendarForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/tarefas.php?operacao=inserir",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage,
            });
        });

        $("#alterarForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/tarefas.php?operacao=alterar",
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

        function atualizarAgenda() {
            window.location.reload();
        }
        function limpar() {
            buscar(null, null, null);
            window.location.reload();
        }
        buscar($("#FiltroAtendente").val());

        function buscar(idAtendente) {
           /*  alert(idAtendente); */

            $.ajax({
                type: 'POST', 
                dataType: 'html', 
                url: '../database/tarefas.php?operacao=filtroAgenda', 
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    idAtendente: idAtendente
                },
                /* success: window.location.reload(), */
                error: function(e) {
                    alert('Erro: ' + JSON.stringify(e));

                    return null;
                }
            });
            
        }
        
       

        $("#FiltroAtendente").change(function() {
            buscar($("#FiltroAtendente").val());
        })

        $('.btnAbre').click(function() {
            $('.menuFiltros').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });
    </script>
</body>

</html>