<body class="bg-transparent">
    <div class="container-fluid mb-3">
        <div>
            <?php
            //******************* Alterar Tarefa *******************
            if (isset($_GET['idTarefa'])) { ?>
                <form method="post" id="editar">
                    <div class="row">
                        <div class="col-md-6 form-group">

                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                            <div class="for-group" style="margin-top: 22px;">
                                <input type="text" class="form-control" name="tituloTarefa"
                                    value="<?php echo $tarefas['tituloTarefa'] ?>" autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-6 form-group">

                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">ID/Demanda
                                Relacionada</label>
                            <div class="for-group" style="margin-top: 22px;">
                                <input type="hidden" class="form-control" name="idTarefa"
                                    value="<?php echo $tarefas['idTarefa'] ?>" style="margin-bottom: -20px;">
                                <input type="hidden" class="form-control" name="idDemanda"
                                    value="<?php echo $tarefas['idDemanda'] ?>" style="margin-bottom: -20px;">
                                <input type="text" class="form-control"
                                    value="<?php echo $tarefas['idDemanda'] ?> - <?php echo $tarefas['tituloDemanda'] ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Cliente</label>
                                <?php
                                ?>
                                <input type="text" class="form-control" value="<?php echo $tarefas['nomeCliente'] ?>"
                                    readonly>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Reponsável</label>
                                <input type="text" class="form-control" value="<?php echo $tarefas['nomeUsuario'] ?>"
                                    readonly>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="labelForm">Data</label>
                                <input type="date" class="data select form-control"
                                    value="<?php echo $tarefas['dataCobrado'] ?>" name="dataCobrado" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="labelForm">Inicio</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaInicioCobrado'] ?>" name="horaInicioCobrado"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="labelForm">Fim</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaFinalCobrado'] ?>" name="horaFinalCobrado"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row card-footer bg-transparent">
                        <hr>
                        <div class="col-sm" style="text-align:right">
                            <button type="submit" formaction="../database/tarefas.php?operacao=alterar"
                                class="btn btn-warning">Atualizar Tarefa</button>
                        </div>
                    </div>
                </form>
            <?php }
            //******************* Criar Tarefa *******************
            else { ?>
                <form method="post" id="form1">
                    <div class="row">
                        <div class="col-md-6 form-group">

                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                            <div class="for-group" style="margin-top: 22px;">
                                <input type="text" class="form-control" name="tituloTarefa" autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-6 form-group">

                            <label class='control-label' for='inputNormal' style="margin-top: 10px;">ID/Demanda
                                Relacionada</label>
                            <div class="for-group" style="margin-top: 22px;">
                                <input type="hidden" class="form-control" name="idDemanda"
                                    value="<?php echo $demanda['idDemanda'] ?>" style="margin-bottom: -20px;">
                                <input type="text" class="form-control"
                                    value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Cliente</label>
                                <?php
                                ?>
                                <input type="hidden" class="form-control" name="idCliente"
                                    value="<?php echo $demanda['idCliente'] ?>">
                                <input type="text" class="form-control" value="<?php echo $cliente['nomeCliente'] ?>"
                                    readonly>

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
                                        if ($atendente['idUsuario'] == $idAtendente) {
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
                                        <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="labelForm">Data</label>
                                <input type="date" class="data select form-control" name="dataCobrado" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="labelForm">Inicio</label>
                                <input type="time" class="data select form-control" name="horaInicioCobrado"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="labelForm">Fim</label>
                                <input type="time" class="data select form-control" name="horaFinalCobrado"
                                    autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" formaction="../database/tarefas.php?operacao=inserir"
                            class="btn btn-info">Inserir Tarefa</button>
                    </div>
                </form>
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
                            } ?>
                            <td class="text-center">
                                <?php echo $Previsto ?>
                                <?php echo $horaInicioPrevisto ?>
                                <?php echo $horaFinalPrevisto ?> (
                                <?php echo $tarefas['horasPrevisto'] ?>)
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
                            } ?>
                            <td class="text-center">
                                <?php echo $dataReal ?>
                                <?php echo $horaInicioReal ?>
                                <?php echo $horaFinalReal ?> (
                                <?php echo $tarefas['horasReal'] ?>)
                            </td>
                            <?php
                            if ($tarefas['dataCobrado'] != null && $tarefas['dataCobrado'] != "0000-00-00") {
                                $dataCobrado = date('d/m/Y', strtotime($tarefas['dataCobrado']));
                            } else {
                                $dataCobrado = "00/00/0000";
                            }
                            $horaInicioCobrado = $tarefas['horaInicioCobrado'];
                            if ($horaInicioCobrado != null) {
                                $horaInicioCobrado = date('H:i', strtotime($horaInicioCobrado));
                            } else {
                                $horaInicioCobrado = "00:00";
                            }
                            $horaFinalCobrado = $tarefas['horaFinalCobrado'];
                            if ($horaFinalCobrado != null) {
                                $horaFinalCobrado = date('H:i', strtotime($horaFinalCobrado));
                            } else {
                                $horaFinalCobrado = "00:00";
                            } ?>
                            <td class="text-center">
                                <?php echo $dataCobrado ?>
                                <?php echo $horaInicioCobrado ?>
                                <?php echo $horaFinalCobrado ?> (
                                <?php echo $tarefas['horasCobrado'] ?>)
                            </td>
                            <td class="text-center">
                                <?php if ($horaInicioReal != "00:00" && $horaFinalReal == "00:00") { ?>
                                    <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop"
                                        data-id="<?php echo $tarefas['idTarefa'] ?>"
                                        data-data-execucao="<?php echo $tarefas['horaInicioReal'] ?>"
                                        data-demanda="<?php echo $tarefas['idDemanda'] ?>" />
                                <?php }
                                if ($horaInicioReal == "00:00") { ?>
                                    <input type="button" class="startButton btn btn-success btn-sm" value="Start"
                                        data-id="<?php echo $tarefas['idTarefa'] ?>"
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
                                } ?>
                                <td class="text-center">
                                    <?php echo $Previsto ?>
                                    <?php echo $horaInicioPrevisto ?>
                                    <?php echo $horaFinalPrevisto ?> (
                                    <?php echo $tarefa['horasPrevisto'] ?>)
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
                                } ?>
                                <td class="text-center">
                                    <?php echo $dataReal ?>
                                    <?php echo $horaInicioReal ?>
                                    <?php echo $horaFinalReal ?> (
                                    <?php echo $tarefa['horasReal'] ?>)
                                </td>
                                <?php
                                if ($tarefa['dataCobrado'] != null && $tarefa['dataCobrado'] != "0000-00-00") {
                                    $dataCobrado = date('d/m/Y', strtotime($tarefa['dataCobrado']));
                                } else {
                                    $dataCobrado = "00/00/0000";
                                }
                                $horaInicioCobrado = $tarefa['horaInicioCobrado'];
                                if ($horaInicioCobrado != null) {
                                    $horaInicioCobrado = date('H:i', strtotime($horaInicioCobrado));
                                } else {
                                    $horaInicioCobrado = "00:00";
                                }
                                $horaFinalCobrado = $tarefa['horaFinalCobrado'];
                                if ($horaFinalCobrado != null) {
                                    $horaFinalCobrado = date('H:i', strtotime($horaFinalCobrado));
                                } else {
                                    $horaFinalCobrado = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $dataCobrado ?>
                                    <?php echo $horaInicioCobrado ?>
                                    <?php echo $horaFinalCobrado ?> (
                                    <?php echo $tarefa['horasCobrado'] ?>)
                                </td>
                                <td class="text-center">
                                    <?php if ($horaInicioReal != "00:00" && $horaFinalReal == "00:00") { ?>
                                        <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop"
                                            data-id="<?php echo $tarefa['idTarefa'] ?>"
                                            data-data-execucao="<?php echo $tarefa['horaInicioReal'] ?>"
                                            data-demanda="<?php echo $tarefa['idDemanda'] ?>" />
                                    <?php } ?>
                                    <?php if ($horaInicioReal == "00:00") { ?>
                                        <input type="button" class="startButton btn btn-success btn-sm" value="Start"
                                            data-id="<?php echo $tarefa['idTarefa'] ?>"
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
                var horaInicioCobrado = $(this).data('data-execucao');
                var idDemanda = $(this).data('demanda');
                var form_data = { idTarefa: idTarefa, horaInicioCobrado: horaInicioCobrado, idDemanda: idDemanda };
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
                var idDemanda = $(this).data('demanda');
                var form_data = { idTarefa: idTarefa, idDemanda: idDemanda };
                $.ajax({
                    url: "../database/tarefas.php?operacao=start",
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
    </script>
</body>

</html>