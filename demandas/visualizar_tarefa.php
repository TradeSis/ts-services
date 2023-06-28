<?php
// gabriel 06032023 11:25 adicionado required nas datas da tarefa
// gabriel 28022023 16:25 alterado para selecionar responsável
// gabriel 03022023 18:07 adicionado script, form alterado para inserir tarefa
// helio 01022023 alterado para include_once
// gabriel 01022023 15:04 - nav adicionada, tarefas adicionadas

include_once '../head.php';
include_once '../database/demanda.php';
include_once '../database/tarefas.php';
include_once '../database/usuario.php';
include_once '../database/clientes.php';
include_once '../database/tipoocorrencia.php';

$idDemanda = $_GET['idDemanda'];
$idAtendente = $_SESSION['idUsuario'];
$demanda = buscaDemandas($idDemanda);
$atendentes = buscaAtendente();
$ocorrencias = buscaTipoOcorrencia();
$cliente = buscaClientes($demanda["idCliente"]);
$idTarefa = null;

if (isset($_GET['idTarefa'])) {
    $idTarefa = $_GET['idTarefa'];
}

$tarefas = buscaTarefas($idDemanda, $idTarefa);

?>

<body class="bg-transparent">
    <div class="container-fluid mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="comentarios.php?idDemanda=<?php echo $idDemanda ?>">Comentarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" style="color:blue"
                    href="visualizar_tarefa.php?idDemanda=<?php echo $idDemanda ?>">Tarefas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="previsao.php?idDemanda=<?php echo $idDemanda ?>">Previsão</a>
            </li>
        </ul>
        <div class="card">
            <div class="container-fluid mt-1 mb-3">
                <?php
                //******************* Alterar Tarefa *******************
                if (isset($_GET['idTarefa'])) { ?>
                    <form method="post" id="editar">
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
                                        value="<?php echo $tarefas['data'] ?>" name="data" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control"
                                        value="<?php echo $tarefas['horaInicio'] ?>" name="horaInicio" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control"
                                        value="<?php echo $tarefas['horaFinal'] ?>" name="horaFinal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row card-footer bg-transparent">
                            <hr>
                            <div class="col-sm" style="text-align:left">
                                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i
                                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
                            </div>
                            <div class="col-sm" style="text-align:right">
                                <?php if ($tarefas['horaStart'] == null) { ?>
                                    <input type="button" id="startAlterarButton" class="btn btn-success" value="Start" />
                                <?php } ?>
                                <input type="submit" name="submit" id="submit" class="btn btn-warning"
                                    value="Atualizar Tarefa" />
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
                                    <input type="date" class="data select form-control" name="data" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" name="horaInicio" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" name="horaFinal" autocomplete="off"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <input type="button" id="startButton" class="btn btn-success" value="Start" />
                            <input type="button" id="inserirButton" class="btn btn-info" value="Inserir Tarefa" />
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
        <div class="card mt-2">
            <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Título</th>
                            <th class="text-center">Atendente</th>
                            <th class="text-center">Ocorrência</th>
                            <th class="text-center">Data</th>
                            <th class="text-center">Início</th>
                            <th class="text-center">Fim</th>
                            <th class="text-center">Duração</th>
                            <th class="text-center">Start</th>
                            <th class="text-center">Stop</th>
                            <th class="text-center">Tempo</th>
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
                                if ($tarefas['data'] != null && $tarefas['data'] != "0000-00-00") {
                                    $data = date('d/m/Y', strtotime($tarefas['data']));
                                } else {
                                    $data = "00/00/0000";
                                } ?>
                                <td class="text-center">
                                    <?php echo $data ?>
                                </td>
                                <?php
                                $horaInicio = $tarefas['horaInicio'];
                                if ($horaInicio != null) {
                                    $horaInicio = date('H:i', strtotime($horaInicio));
                                } else {
                                    $horaInicio = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaInicio ?>
                                </td>
                                <?php
                                $horaFinal = $tarefas['horaFinal'];
                                if ($horaFinal != null) {
                                    $horaFinal = date('H:i', strtotime($horaFinal));
                                } else {
                                    $horaFinal = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaFinal ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $tarefas['horasCobrado'] ?>
                                </td>
                                <?php
                                $horaStart = $tarefas['horaStart'];
                                if ($horaStart != null) {
                                    $horaStart = date('H:i', strtotime($horaStart));
                                } else {
                                    $horaStart = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaStart ?>
                                </td>
                                <?php
                                $horaStop = $tarefas['horaStop'];
                                if ($horaStop != null) {
                                    $horaStop = date('H:i', strtotime($horaStop));
                                } else {
                                    $horaStop = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $horaStop ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $tarefas['horasReal'] ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($horaStart != "00:00" && $horaStop == "00:00") { ?>
                                        <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop"
                                            data-id="<?php echo $tarefas['idTarefa'] ?>"
                                            data-data-execucao="<?php echo $tarefas['horaStart'] ?>"
                                            data-demanda="<?php echo $tarefas['idDemanda'] ?>" />
                                    <?php } ?>
                                    <a class="btn btn-primary btn-sm"
                                        href="visualizar_tarefa.php?idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
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
                                    if ($tarefa['data'] != null && $tarefa['data'] != "0000-00-00") {
                                        $data = date('d/m/Y', strtotime($tarefa['data']));
                                    } else {
                                        $data = "00/00/0000";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $data ?>
                                    </td>
                                    <?php
                                    $horaInicio = $tarefa['horaInicio'];
                                    if ($horaInicio != null) {
                                        $horaInicio = date('H:i', strtotime($horaInicio));
                                    } else {
                                        $horaInicio = "00:00";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $horaInicio ?>
                                    </td>
                                    <?php
                                    $horaFinal = $tarefa['horaFinal'];
                                    if ($horaFinal != null) {
                                        $horaFinal = date('H:i', strtotime($horaFinal));
                                    } else {
                                        $horaFinal = "00:00";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $horaFinal ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $tarefa['horasCobrado'] ?>
                                    </td>
                                    <?php
                                    $horaStart = $tarefa['horaStart'];
                                    if ($horaStart != null) {
                                        $horaStart = date('d/m/Y H:i', strtotime($horaStart));
                                    } else {
                                        $horaStart = "00:00";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $horaStart ?>
                                    </td>
                                    <?php
                                    $horaStop = $tarefa['horaStop'];
                                    if ($horaStop != null) {
                                        $horaStop = date('H:i', strtotime($horaStop));
                                    } else {
                                        $horaStop = "00:00";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $horaStop ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $tarefa['horasReal'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($horaStart != "00:00" && $horaStop == "00:00") { ?>
                                            <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop"
                                                data-id="<?php echo $tarefa['idTarefa'] ?>"
                                                data-data-execucao="<?php echo $tarefa['horaStart'] ?>"
                                                data-demanda="<?php echo $tarefa['idDemanda'] ?>" />
                                        <?php } ?>
                                        <a class="btn btn-primary btn-sm"
                                            href="visualizar_tarefa.php?idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
                                            role="button">Alterar</a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function () {

            $('#editar').on('submit', function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: "../database/tarefas.php?operacao=alterar",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                })
            });

            $('#inserirButton').click(function () {
                var form_data = $('#form1').serialize();
                $.ajax({
                    url: "../database/tarefas.php?operacao=inserir",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                });
            });

            $('#startButton').click(function () {
                var form_data = $('#form1').serialize();
                $.ajax({
                    url: "../database/tarefas.php?operacao=start",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                });
            });

            $('#startAlterarButton').click(function () {
                var form_data = $('#editar').serialize();
                $.ajax({
                    url: "../database/tarefas.php?operacao=startAlterar",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                });
            });

            $('.stopButton').click(function () {
                var idTarefa = $(this).data('id');
                var horaInicio = $(this).data('data-execucao');
                var idDemanda = $(this).data('demanda');
                var form_data = { idTarefa: idTarefa, horaInicio: horaInicio, idDemanda: idDemanda };
                $.ajax({
                    url: "../database/tarefas.php?operacao=stop",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                });
            });

        });

        function refreshPage() {
            window.location.reload();
        }

    </script>
</body>

</html>