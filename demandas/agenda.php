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

<!--------- INSERIR/AGENDAR --------->
<div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" role="dialog"
    aria-labelledby="inserirModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Inserir Tarefa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container">
          <form method="post" id="inserirForm">
            <div class="row">
              <div class="col-md-6 form-group">
                <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                <div class="for-group" style="margin-top: 22px;">
                  <input type="text" class="form-control" name="tituloTarefa" id="newtitulo" autocomplete="off"
                    required>
                </div>
                <input type="hidden" class="form-control" name="idDemanda" value="null" id="newidDemanda">
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Cliente</label>
                  <div class="form-group" style="margin-top: 40px;">
                    <select class="form-control" name="idCliente" id="newidCliente">
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
                  <div class="form-group" style="margin-top: 20px;">
                    <select class="form-control" name="idAtendente" id="newidAtendente">
                      <!-- gabriel 13102023 id596 removido a possibilidade de adicionar tarefa sem responsável -->
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
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class='control-label' for='inputNormal'>Ocorrência</label>
                  <div class="form-group" style="margin-top: 20px;">
                    <select class="form-control" name="idTipoOcorrencia" id="newidTipoOcorrencia">
                      <option value="null">Selecione</option>
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
              <button type="submit" class="btn btn-warning" id="inserirStartBtn">Start</button>
              <button type="submit" class="btn btn-success" id="inserirBtn">Inserir</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'alterarTarefaModal.php'; ?>

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
                success: function (response) {
                    console.log('Session variable set successfully.');
                },
                error: function (xhr, status, error) {
                    console.error('An error occurred:', error);
                }
            });
        }

        $(document).ready(function () {
            //Gabriel 22092023 id542 verifica se possui $_SESSION['ultimoTab'] se não, padrão (mês)
            var vdefaultView = '<?php echo isset($_SESSION['ultimoTab']) ? $_SESSION['ultimoTab'] : 'month' ?>';
            var today = new Date();
            var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 3, 0);
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
                        minTime: "08:00:00",
                        maxTime: "20:00:00"
                    },
                    agendaDay: {
                        minTime: "08:00:00",
                        maxTime: "20:00:00"
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
                            //Gabriel 06102023 ID 596 ajustado para ID ao invés de classe
                            $('#menuFiltros').toggleClass('mostra');
                            $('.diviFrame').toggleClass('mostra');
                        }
                    },
                    novo: {
                        text: 'Novo',
                        click: function () {
                            //Gabriel 11102023 ID 596 alterado para utilizar o mesmo modal de inserir
                            $('#inserirModal').modal('show');
                        }
                    }
                },
                events: [
                    <?php
                    $colors = array('#FF6B6B', '#77DD77', '#6CA6CD', '#FFD700', '#FF69B4', '#00CED1');
                    // helio 26092023 - inicio teste de cores
                    $cor_previsto = '#77DD77';
                    $cor_executando = '#FF6B6B';
                    $cor_diatodo = '#6CA6CD';
                    $colorIndex = 0;
                    foreach ($tarefas as $tarefa) {
                        $color = $colors[$colorIndex % count($colors)];
                        $colorIndex++;

                        if ($tarefa['idDemanda'] !== null) {
                            $tituloTarefa = empty($tarefa['tituloTarefa']) ? $tarefa['tituloDemanda'] . " (" . $tarefa['nomeUsuario'] . ")" : $tarefa['tituloTarefa'];
                        } else {
                            $tituloTarefa = empty($tarefa['tituloTarefa']) ? $tarefa['tituloTarefa'] . " (" . $tarefa['nomeUsuario'] . ")" : $tarefa['tituloTarefa'];
                        }

                        // substituindo dataPrevisto por Real, quando Real existir
                        if ($tarefa['dataReal'] != null) {
                            $dataPrevisto = $tarefa['dataReal'];
                            $allDay = false;
                            $dtf = $tarefa['horaFinalReal'];
                            // sem realfinal, coloca sempre mais 1 hora, para melhorar visualmente
                            if ($tarefa['horaFinalReal'] == null) {
                                $dtf = date('H:00:00', strtotime('1 hour'));
                                $color = $cor_executando; // helio 26092023 - inicio teste de cores
                            }
                            $horaInicioPrevisto = is_null($tarefa['horaInicioReal']) ? "08:00:00" : $tarefa['horaInicioReal'];
                            $horaFinalPrevisto = is_null($tarefa['horaFinalReal']) ? $dtf : $tarefa['horaFinalReal'];
                        } else {
                            $cor = $cor_previsto; // helio 26092023 - inicio teste de cores
                            if ($tarefa['horaInicioPrevisto'] == null) {
                                $allDay = true;
                            } else {
                                $allDay = false;
                            } // teste de allDay
                            $dataPrevisto = $tarefa['Previsto'];
                            $horaInicioPrevisto = is_null($tarefa['horaInicioPrevisto']) ? "08:00:00" : $tarefa['horaInicioPrevisto'];
                            $horaFinalPrevisto = is_null($tarefa['horaFinalPrevisto']) ? "19:00:00" : $tarefa['horaFinalPrevisto'];
                        }
                        if ($allDay == true) {
                            $color = $cor_diatodo;
                        }
                        ?>
                        {
                            allDay: <?php if ($allDay == true) {
                                echo 'true';
                            } else {
                                echo 'false';
                            } // teste de allDay ?>,
                            _id: '<?php echo $tarefa['idTarefa']; ?>',
                            title: '<?php echo $tituloTarefa ?>',
                            start: '<?php echo $dataPrevisto . ' ' . $horaInicioPrevisto; // uso dataPrevisto com real/previsto ?>',
                            end: '<?php echo $dataPrevisto . ' ' . $horaFinalPrevisto; // uso dataPrevisto com real/previsto ?>',
                            idTarefa: '<?php echo $tarefa['idTarefa']; ?>',
                            color: '<?php echo $color; ?>'
                            //Gabriel 11102023 ID 596 removido dados desnecessários
                        },
                    <?php } ?>
                ],
                eventRender: function (event, element) {
                    element.css('font-weight', 'bold');
                },
                eventClick: function (calEvent, jsEvent, view) {
                    //Gabriel 11102023 ID 596 chama o mesmo script que preenche o alterarModal
                    var idTarefa = calEvent.idTarefa;
                    BuscarAlterar(idTarefa);
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
        //Gabriel 11102023 ID 596 alterado para utilizar o mesmo modal de inserir
        var inserirModal = document.getElementById("inserirModal");

        var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

        inserirBtn.onclick = function () {
            inserirModal.style.display = "block";
        };


        window.onclick = function (event) {
            if (event.target == inserirModal) {
                inserirModal.style.display = "none";
            }
        };

        $('.btnAbre').click(function () {
            //Gabriel 06102023 ID 596 ajustado para ID ao invés de classe
            $('#menuFiltros').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });

        function refreshPage() {
            window.location.reload();
        }

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
            $("#inserirForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                var vurl;
                if ($("#inserirStartBtn").prop("clicked")) {
                    vurl = "../database/tarefas.php?operacao=inserirStart";
                } else {
                    vurl = "../database/tarefas.php?operacao=inserir";
                }
                $.ajax({
                    url: vurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    //gabriel 13102023 id 596 fix atualizar pagina correta
                    success: refreshPage
                });
            });

            $("#inserirStartBtn").click(function () {
                $("#inserirBtn").prop("clicked", false);
                $(this).prop("clicked", true);
            });

            $("#inserirBtn").click(function () {
                $("#inserirStartBtn").prop("clicked", false);
                $(this).prop("clicked", true);
            });

            $("#alterarForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }
                var vurl;
                if ($("#stopButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=stop";
                }
                if ($("#startButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=start";
                }
                if ($("#realizadoButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=realizado";
                }
                if ($("#atualizarButtonModal").is(":focus")) {
                    vurl = "../database/tarefas.php?operacao=alterar";
                }
                $.ajax({
                    url: vurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage

                });
            });
            function refreshPage() {
                window.location.reload();
            }
        });

    </script>
</body>

</html>