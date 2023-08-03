<?php
include_once '../head.php';
?>

<body class="bg-transparent">
    <div class="container-fluid">
        <div>
            <?php
            //******************* Alterar Tarefa *******************
            if (isset($_GET['idTarefa'])) { ?>
                <form method="post" id="editar">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                            <div class="form-group" style="margin-top: 22px;">
                                <input type="text" class="form-control" name="tituloTarefa"
                                    value="<?php echo $tarefas['tituloTarefa'] ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">ID/Demanda
                                Relacionada</label>
                            <div class="form-group" style="margin-top: 22px;">
                                <input type="hidden" class="form-control" name="idTarefa"
                                    value="<?php echo $tarefas['idTarefa'] ?>" style="margin-bottom: -20px;">
                                <input type="hidden" class="form-control" name="idDemanda"
                                    value="<?php echo $tarefas['idDemanda'] ?>" style="margin-bottom: -20px;">
                                <input type="text" class="form-control"
                                    value="<?php echo $tarefas['idDemanda'] ?> - <?php echo $tarefas['tituloDemanda'] ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">Cliente</label>
                            <div class="form-group" style="margin-top: 22px;">
                                <input type="text" class="form-control" 
                                    value="<?php echo $tarefas['nomeCliente'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Reponsável</label>
                                <select class="form-control" name="idAtendente">
                                    <?php
                                    foreach ($atendentes as $atendente) {
                                        ?>
                                        <option <?php
                                        if ($atendente['idUsuario'] == $tarefas['idAtendente']) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Ocorrência</label>
                                <select class="form-control" name="idTipoOcorrencia">
                                    <?php
                                    foreach ($ocorrencias as $ocorrencia) {
                                        ?>
                                        <option <?php
                                        if ($ocorrencia['idTipoOcorrencia'] == $tarefas['idTipoOcorrencia']) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                                            <?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -14px;">
                            <div class="form-group">
                                <label class="labelForm">Horas Cobrado</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaCobrado'] ?>" name="horaCobrado"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -30px;">
                            <div class="form-group">
                                <label class="labelForm">Data Real</label>
                                <input type="date" class="data select form-control"
                                    value="<?php echo $tarefas['dataReal'] ?>" name="dataReal" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -30px;">
                            <div class="form-group">
                                <label class="labelForm">Inicio</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaInicioReal'] ?>" name="horaInicioReal"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -30px;">
                            <div class="form-group">
                                <label class="labelForm">Fim</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaFinalReal'] ?>" name="horaFinalReal"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -30px;">
                            <div class="form-group">
                                <label class="labelForm">Data Previsão</label>
                                <input type="date" class="data select form-control"
                                    value="<?php echo $tarefas['Previsto'] ?>" name="Previsto" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -30px;">
                            <div class="form-group">
                                <label class="labelForm">Inicio</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaInicioPrevisto'] ?>" name="horaInicioPrevisto"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: -30px;">
                            <div class="form-group">
                                <label class="labelForm">Fim</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaFinalPrevisto'] ?>" name="horaFinalPrevisto"
                                    autocomplete="off">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row card-footer bg-transparent">
                        <hr>
                        <div class="col-sm" style="text-align:right">
                            <button type="submit" formaction="../database/tarefas.php?operacao=alterar"
                                class="btn btn-warning">Atualiza</button>
                        </div>
                    </div>
                </form>
            <?php }
            //******************* Criar Tarefa *******************
            else { ?>
            <div class="mb-2" style="text-align:right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#iniciarModal">Iniciar</button>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agendarModal">Agendar</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inserirModal">Nova</button>
            </div>
            

            <?php } ?>
        </div>
        <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Título</th>
                        <th class="text-center">Atendente</th>
                        <th class="text-center">Ocorrência</th>
                        <th class="text-center">Previsão</th>
                        <th class="text-center">Real</th>
                        <th class="text-center">Cobrado</th>
                        <th class="text-center">Editar</th>
                    </tr>
                </thead>
                <tbody class="fonteCorpo">
                    <?php
                    if (isset($tarefas['idTarefa'])) { ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $tarefas['idTarefa'] ?>
                            </td>
                            <td class="text-center">
                                <?php echo $tarefas['tituloTarefa'] ?>
                            </td>
                            <td class="text-center">
                                <?php echo $tarefas['nomeUsuario'] ?>
                            </td>
                            <td class="text-center">
                                <?php echo $tarefas['nomeTipoOcorrencia'] ?>
                            </td>
                            <?php
                            if ($tarefas['Previsto'] != null && $tarefas['Previsto'] != "0000-00-00") {
                                $Previsto = date('d/m/Y', strtotime($tarefas['Previsto']));
                            } else {
                                $Previsto = "00/00/0000";
                            }
                            $horaInicioPrevisto = $tarefas['horaInicioPrevisto'];
                            if ($horaInicioPrevisto != null) {
                                $horaInicioPrevisto = date('H:i', strtotime($horaInicioPrevisto));
                            } else {
                                $horaInicioPrevisto = "00:00";
                            }
                            $horaFinalPrevisto = $tarefas['horaFinalPrevisto'];
                            if ($horaFinalPrevisto != null) {
                                $horaFinalPrevisto = date('H:i', strtotime($horaFinalPrevisto));
                            } else {
                                $horaFinalPrevisto = "00:00";
                            } 
                            $horasPrevisto = $tarefas['horasPrevisto'];
                            if ($horasPrevisto != null) {
                                $horasPrevisto = date('H:i', strtotime($tarefas['horasPrevisto']));
                            } else {
                                $horasPrevisto = "00:00";
                            } ?>
                            <td class="text-center">
                                <?php echo $Previsto ?>
                                <?php echo $horaInicioPrevisto ?>
                                <?php echo $horaFinalPrevisto ?> (<?php echo $horasPrevisto?>)
                            </td>
                            <?php
                            if ($tarefas['dataReal'] != null && $tarefas['dataReal'] != "0000-00-00") {
                                $dataReal = date('d/m/Y', strtotime($tarefas['dataReal']));
                            } else {
                                $dataReal = "00/00/0000";
                            }
                            $horaInicioReal = $tarefas['horaInicioReal'];
                            if ($horaInicioReal != null) {
                                $horaInicioReal = date('H:i', strtotime($horaInicioReal));
                            } else {
                                $horaInicioReal = "00:00";
                            }
                            $horaFinalReal = $tarefas['horaFinalReal'];
                            if ($horaFinalReal != null) {
                                $horaFinalReal = date('H:i', strtotime($horaFinalReal));
                            } else {
                                $horaFinalReal = "00:00";
                            } 
                            $horasReal = $tarefas['horasReal'];
                            if ($horasReal != null) {
                                $horasReal = date('H:i', strtotime($tarefas['horasReal']));
                            } else {
                                $horasReal = "00:00";
                            } ?>
                            <td class="text-center">
                                <?php echo $dataReal ?>
                                <?php echo $horaInicioReal ?>
                                <?php echo $horaFinalReal ?> (<?php echo $horasReal?>)
                            </td>                            
                            <?php
                            $horaCobrado = $tarefas['horaCobrado'];
                            if ($horaCobrado != null) {
                                $horaCobrado = date('H:i', strtotime($tarefas['horaCobrado']));
                            } else {
                                $horaCobrado = "00:00";
                            } ?>
                            <td class="text-center">
                            <?php echo $horaCobrado ?>
                            </td>
                            <td class="text-center">
                                <?php if ($horaInicioReal != "00:00" && $horaFinalReal == "00:00") { ?>
                                    <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop"
                                        data-id="<?php echo $tarefas['idTarefa'] ?>"
                                        data-status="<?php echo $idTipoStatus ?>"
                                        data-data-execucao="<?php echo $tarefas['horaInicioReal'] ?>"
                                        data-demanda="<?php echo $tarefas['idDemanda'] ?>" />
                                <?php }
                                if ($horaInicioReal == "00:00") { ?>
                                    <input type="button" class="startButton btn btn-success btn-sm" value="Start"
                                        data-id="<?php echo $tarefas['idTarefa'] ?>"
                                        data-status="<?php echo $idTipoStatus ?>"
                                        data-demanda="<?php echo $tarefas['idDemanda'] ?>" />
                                <?php } ?>
                                <a class="btn btn-primary btn-sm"
                                    href="visualizar.php?id=tarefas&&idTarefa=<?php echo $tarefas['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
                                    role="button">Alterar</a>
                            </td>
                        </tr>
                    <?php } else {
                        foreach ($tarefas as $tarefa) {
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $tarefa['idTarefa'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $tarefa['tituloTarefa'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $tarefa['nomeUsuario'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $tarefa['nomeTipoOcorrencia'] ?>
                                </td>
                                <?php
                                if ($tarefa['Previsto'] != null && $tarefa['Previsto'] != "0000-00-00") {
                                    $Previsto = date('d/m/Y', strtotime($tarefa['Previsto']));
                                } else {
                                    $Previsto = "00/00/0000";
                                }
                                $horaInicioPrevisto = $tarefa['horaInicioPrevisto'];
                                if ($horaInicioPrevisto != null) {
                                    $horaInicioPrevisto = date('H:i', strtotime($horaInicioPrevisto));
                                } else {
                                    $horaInicioPrevisto = "00:00";
                                }
                                $horaFinalPrevisto = $tarefa['horaFinalPrevisto'];
                                if ($horaFinalPrevisto != null) {
                                    $horaFinalPrevisto = date('H:i', strtotime($horaFinalPrevisto));
                                } else {
                                    $horaFinalPrevisto = "00:00";
                                } 
                                $horasPrevisto = $tarefa['horasPrevisto'];
                                if ($horasPrevisto != null) {
                                    $horasPrevisto = date('H:i', strtotime($tarefa['horasPrevisto']));
                                } else {
                                    $horasPrevisto = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $Previsto ?>
                                    <?php echo $horaInicioPrevisto ?>
                                    <?php echo $horaFinalPrevisto ?> (<?php echo $horasPrevisto?>)
                                </td>
                                <?php
                                if ($tarefa['dataReal'] != null && $tarefa['dataReal'] != "0000-00-00") {
                                    $dataReal = date('d/m/Y', strtotime($tarefa['dataReal']));
                                } else {
                                    $dataReal = "00/00/0000";
                                }
                                $horaInicioReal = $tarefa['horaInicioReal'];
                                if ($horaInicioReal != null) {
                                    $horaInicioReal = date('H:i', strtotime($horaInicioReal));
                                } else {
                                    $horaInicioReal = "00:00";
                                }
                                $horaFinalReal = $tarefa['horaFinalReal'];
                                if ($horaFinalReal != null) {
                                    $horaFinalReal = date('H:i', strtotime($horaFinalReal));
                                } else {
                                    $horaFinalReal = "00:00";
                                } 
                                $horasReal = $tarefa['horasReal'];
                                if ($horasReal != null) {
                                    $horasReal = date('H:i', strtotime($tarefa['horasReal']));
                                } else {
                                    $horasReal = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $dataReal ?>
                                    <?php echo $horaInicioReal ?>
                                    <?php echo $horaFinalReal ?> (<?php echo $horasReal?>)
                                </td> 
                                <?php
                                $horaCobrado = $tarefa['horaCobrado'];
                                if ($horaCobrado != null) {
                                    $horaCobrado = date('H:i', strtotime($tarefa['horaCobrado']));
                                } else {
                                    $horaCobrado = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaCobrado ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($horaInicioReal != "00:00" && $horaFinalReal == "00:00") { ?>
                                        <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop"
                                            data-id="<?php echo $tarefa['idTarefa'] ?>"
                                            data-status="<?php echo $idTipoStatus ?>"
                                            data-data-execucao="<?php echo $tarefa['horaInicioReal'] ?>"
                                            data-demanda="<?php echo $tarefa['idDemanda'] ?>" />
                                    <?php } ?>
                                    <?php if ($horaInicioReal == "00:00") { ?>
                                        <input type="button" class="startButton btn btn-success btn-sm" value="Start"
                                            data-id="<?php echo $tarefa['idTarefa'] ?>"
                                            data-status="<?php echo $idTipoStatus ?>"
                                            data-demanda="<?php echo $tarefa['idDemanda'] ?>" />
                                        <input type="button" class="realizadoButton btn btn-warning btn-sm" value="Realizado"
                                            data-id="<?php echo $tarefa['idTarefa'] ?>"
                                            data-status="<?php echo $idTipoStatus ?>"
                                            data-demanda="<?php echo $tarefa['idDemanda'] ?>" />
                                    <?php } ?>
                                    <a class="btn btn-primary btn-sm"
                                        href="visualizar.php?id=tarefas&&idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
                                        role="button">Alterar</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>




    <script>
        $(document).ready(function () {

            $('.stopButton').click(function () {
                var idTarefa = $(this).data('id');
                var tipoStatusDemanda = $(this).data('status');
                var horaInicioCobrado = $(this).data('data-execucao');
                var idDemanda = $(this).data('demanda');
                var form_data = { idTarefa: idTarefa, tipoStatusDemanda: tipoStatusDemanda, horaInicioCobrado: horaInicioCobrado, idDemanda: idDemanda };
                $.ajax({
                    url: "../database/tarefas.php?operacao=stop",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage('tarefas', idDemanda)
                });
            });

            $('.startButton').click(function () {
                var idTarefa = $(this).data('id');
                var tipoStatusDemanda = $(this).data('status');
                var idDemanda = $(this).data('demanda');
                var form_data = { idTarefa: idTarefa, tipoStatusDemanda: tipoStatusDemanda, idDemanda: idDemanda };
                $.ajax({
                    url: "../database/tarefas.php?operacao=start",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage('tarefas', idDemanda)
                });
            });

            $('.realizadoButton').click(function () {
                var idTarefa = $(this).data('id');
                var tipoStatusDemanda = $(this).data('status');
                var idDemanda = $(this).data('demanda');
                var form_data = { idTarefa: idTarefa, tipoStatusDemanda: tipoStatusDemanda, idDemanda: idDemanda };
                $.ajax({
                    url: "../database/tarefas.php?operacao=realizado",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage('tarefas', idDemanda)
                });
            });

        });

        function refreshPage(tab, idDemanda) {
            window.location.reload();
            var url = window.location.href.split('?')[0];
            var newUrl = url + '?id=' + tab + '&&idDemanda=' + idDemanda;
            window.location.href = newUrl;
        }

        var agendarModal = document.getElementById("agendarModal");
        var iniciarModal = document.getElementById("iniciarModal");
        var inserirModal = document.getElementById("inserirModal");

        var iniciarBtn = document.querySelector("button[data-target='#agendarModal']");
        var iniciarBtn = document.querySelector("button[data-target='#iniciarModal']");
        var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

        agendarBtn.onclick = function () {
            agendarModal.style.display = "block";
        };

        iniciarBtn.onclick = function () {
            iniciarModal.style.display = "block";
        };

        inserirBtn.onclick = function () {
            inserirModal.style.display = "block";
        };

        window.onclick = function (event) {
            if (event.target == agendarModal) {
                agendarModal.style.display = "none";
            }

            if (event.target == iniciarModal) {
                iniciarModal.style.display = "none";
            }

            if (event.target == inserirModal) {
                inserirModal.style.display = "none";
            }
        };
</script>
</body>

</html>