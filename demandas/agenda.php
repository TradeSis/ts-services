<!-- Gabriel 06102023 ID 596 mudanças em agenda e tarefas -->
<!-- Gabriel 06102023 ID 596 removido php para indexTarefa -->


    <nav style="margin-left:230px;margin-bottom:-50px">
        <ul>
            <form action="" method="post">
                <label class="labelForm">Responsável</label>
                <select class="form-control text-center" name="idAtendente" id="FiltroUsuarioAgenda"
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
    <!-- Gabriel 06102023 ID 596 ajustado posiçao -->
    <nav id="menuFiltros2" class="menuFiltros" style="margin-top:-55px">
        <div class="titulo"><span>Filtrar por:</span></div>
        <ul>
            <li class="ls-label col-sm-12 mr-1"> <!-- ABERTO/FECHADO -->
                <form class="d-flex" action="" method="post" style="text-align: right;">
                    <!-- Gabriel 11102023 ID 596 alterado nome do filtro -->
                    <select class="form-control" name="statusTarefa" id="FiltroStatusTarefaAgenda"
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
                            $('#menuFiltros2').toggleClass('mostra');
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
                    $cor_previsto   = '#77DD77';
                    $cor_executando = '#FF6B6B';
                    $cor_diatodo    = '#6CA6CD';
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
                        if ($tarefa['dataReal']!=null) {
                            $dataPrevisto = $tarefa['dataReal'];
                            $allDay = false;
                            $dtf = $tarefa['horaFinalReal'];
                            // sem realfinal, coloca sempre mais 1 hora, para melhorar visualmente
                            if ($tarefa['horaFinalReal']==null) {
                                $dtf   = date('H:00:00', strtotime('1 hour')); 
                                $color = $cor_executando; // helio 26092023 - inicio teste de cores
                            }
                            $horaInicioPrevisto = is_null($tarefa['horaInicioReal']) ? "08:00:00" : $tarefa['horaInicioReal'];
                            $horaFinalPrevisto = is_null($tarefa['horaFinalReal']) ? $dtf : $tarefa['horaFinalReal'];
                        } else {
                            $cor = $cor_previsto ; // helio 26092023 - inicio teste de cores
                            if ($tarefa['horaInicioPrevisto']==null) { $allDay = true;} else { $allDay = false;} // teste de allDay
                            $dataPrevisto = $tarefa['Previsto'];
                            $horaInicioPrevisto = is_null($tarefa['horaInicioPrevisto']) ? "08:00:00" : $tarefa['horaInicioPrevisto'];
                            $horaFinalPrevisto = is_null($tarefa['horaFinalPrevisto']) ? "19:00:00" : $tarefa['horaFinalPrevisto'];
                        }
                        if ($allDay==true) {$color = $cor_diatodo;}
                        ?>
                    {
                        allDay: <?php if ($allDay==true) { echo 'true';} else { echo 'false';} // teste de allDay ?> ,
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
            $('#menuFiltros2').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });
        function refreshTab(tab) {
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab;
            window.location.href = newUrl;
        }

        $(document).ready(function () {

            //Gabriel 11102023 ID 596 alterado para atualizar os filtros da mesma forma que a table tarefas
            $("#FiltroUsuarioAgenda").change(function () {
                buscar($("#FiltroClientes").val(), $("#FiltroUsuarioAgenda").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefaAgenda").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
                refreshTab('agenda');
            });

            //Gabriel 11102023 ID 596 alterado para atualizar os filtros da mesma forma que a table tarefas
            $("#FiltroStatusTarefaAgenda").change(function () {
                buscar($("#FiltroClientes").val(), $("#FiltroUsuarioAgenda").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefaAgenda").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
                refreshTab('agenda');
            });

            $("#limpar-button").click(function () {
                //Gabriel 11102023 ID 596 alterado para atualizar os filtros da mesma forma que a table tarefas
                buscar($("#FiltroClientes").val(), null, $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), null, $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
                refreshTab('agenda');
            });
        });

    </script>

