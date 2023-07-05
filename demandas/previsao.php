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
                                <input type="text" class="form-control" name="tituloTarefa" value="<?php echo $tarefas['tituloTarefa'] ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class='control-label' for='inputNormal'>ID/Demanda
                                Relacionada</label>
                            <input type="hidden" class="form-control" name="idDemanda"
                                value="<?php echo $tarefas['idDemanda'] ?>">
                            <input type="hidden" class="form-control" name="idTarefa"
                                value="<?php echo $tarefas['idTarefa'] ?>">
                            <input type="text" class="form-control"
                                value="<?php echo $tarefas['idDemanda'] ?> - <?php echo $tarefas['tituloDemanda'] ?>"
                                readonly>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" style="margin-top: 32px;">
                                <label class='control-label' for='inputNormal'>Cliente</label>
                                <?php
                                ?>
                                <input type="text" class="form-control" value="<?php echo $tarefas['nomeCliente'] ?>"
                                    readonly>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: 29px;">
                                <label class='control-label' for='inputNormal'>Reponsável</label>
                                <input type="text" class="form-control" value="<?php echo $tarefas['nomeUsuario'] ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="labelForm">Data Previsão</label>
                                <input type="date" class="data select form-control"
                                    value="<?php echo $tarefas['Previsto'] ?>" name="Previsto" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="labelForm">Inicio</label>
                                <input type="time" class="data select form-control"
                                    value="<?php echo $tarefas['horaInicioPrevisto'] ?>" name="horaInicioPrevisto"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
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
                            <button type="submit" formaction="../database/tarefas.php?operacao=alterarPrevisao"
                                class="btn btn-warning">Atualizar Previsão</button>
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
                            <label class='control-label' for='inputNormal'>ID/Demanda
                                Relacionada</label>
                            <input type="hidden" class="form-control" name="idDemanda"
                                value="<?php echo $demanda['idDemanda'] ?>">
                            <input type="text" class="form-control"
                                value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>"
                                readonly>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" style="margin-top: 32px;">
                                <label class='control-label' for='inputNormal'>Cliente</label>
                                <?php
                                ?>
                                <input type="hidden" class="form-control" name="idCliente"
                                    value="<?php echo $demanda['idCliente'] ?>">
                                <input type="text" class="form-control" value="<?php echo $cliente['nomeCliente'] ?>"
                                    readonly>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: 29px;">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="labelForm">Data Previsão</label>
                                <input type="date" class="data select form-control" name="Previsto" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="labelForm">Inicio</label>
                                <input type="time" class="data select form-control" name="horaInicioPrevisto"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="labelForm">Fim</label>
                                <input type="time" class="data select form-control" name="horaFinalPrevisto"
                                    autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" formaction="../database/tarefas.php?operacao=previsao"
                            class="btn btn-info">Inserir Previsão</button>
                    </div>
                </form>
            <?php } ?>
        </div>
        <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Titulo</th>
                        <th class="text-center">Atendente</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Início</th>
                        <th class="text-center">Fim</th>
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
                            <?php
                            if ($tarefas['Previsto'] != null && $tarefas['Previsto'] != "0000-00-00") {
                                $dataCobradoPrevisto = date('d/m/Y', strtotime($tarefas['Previsto']));
                            } else {
                                $dataCobradoPrevisto = "Previsão não definida";
                            } ?>
                            <td class="text-center">
                                <?php echo $dataCobradoPrevisto ?>
                            </td>
                            <?php
                            if ($tarefas['horaInicioPrevisto'] != null) {
                                $horaInicioPrevisto = date('H:i', strtotime($tarefas['horaInicioPrevisto']));
                            } else {
                                $horaInicioPrevisto = "00:00";
                            } ?>
                            <td class="text-center">
                                <?php echo $horaInicioPrevisto ?>
                            </td>
                            <?php
                            if ($tarefas['horaFinalPrevisto'] != null) {
                                $horaFinalPrevisto = date('H:i', strtotime($tarefas['horaFinalPrevisto']));
                            } else {
                                $horaFinalPrevisto = "00:00";
                            } ?>
                            <td class="text-center">
                                <?php echo $horaFinalPrevisto ?>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary btn-sm"
                                    href="visualizar.php?id=previsao&&idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
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
                                <?php
                                if ($tarefa['Previsto'] != null && $tarefa['Previsto'] != "0000-00-00") {
                                    $dataCobradoPrevisto = date('d/m/Y', strtotime($tarefa['Previsto']));
                                } else {
                                    $dataCobradoPrevisto = "Previsão não definida";
                                } ?>
                                <td class="text-center">
                                    <?php echo $dataCobradoPrevisto ?>
                                </td>
                                <?php
                                if ($tarefa['horaInicioPrevisto'] != null) {
                                    $horaInicioPrevisto = date('H:i', strtotime($tarefa['horaInicioPrevisto']));
                                } else {
                                    $horaInicioPrevisto = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaInicioPrevisto ?>
                                </td>
                                <?php
                                if ($tarefa['horaFinalPrevisto'] != null) {
                                    $horaFinalPrevisto = date('H:i', strtotime($tarefa['horaFinalPrevisto']));
                                } else {
                                    $horaFinalPrevisto = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaFinalPrevisto ?>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm"
                                        href="visualizar.php?id=previsao&&idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
                                        role="button">Alterar</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


</body>

</html>