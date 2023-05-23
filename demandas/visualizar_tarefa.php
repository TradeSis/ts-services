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

$idDemanda = $_GET['idDemanda'];
$idAtendente = $_SESSION['idUsuario'];
$idTarefa = null;
$demanda = buscaDemandas($idDemanda);
$atendentes = buscaAtendente();
$cliente = buscaClientes($demanda["idCliente"]);
if (isset($_GET['idTarefa'])) {
    $idTarefa = $_GET['idTarefa'];
}
$tarefas = buscaTarefas($idDemanda, $idTarefa);

?>

<body class="bg-transparent">
    <div class="container-fluid full-width mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="comentarios.php?idDemanda=<?php echo $idDemanda ?>">Comentarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" style="color:blue"
                    href="visualizar_tarefa.php?idDemanda=<?php echo $idDemanda ?>">Tarefas</a>
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
                                    <label class='control-label' for='inputNormal'>Status</label>
                                    <input type="text" class="form-control" value="<?php echo $tarefas['nomeTipoOcorrencia'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="labelForm">Data de Início</label>
                                    <input type="datetime-local" min="2022-01-01" max="2024-12-31"
                                        class="data select form-control"
                                        value="<?php echo $tarefas['dataExecucaoInicio'] ?>" name="dataExecucaoInicio"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="labelForm">Data de Fim</label>
                                    <input type="datetime-local" min="2022-01-01" max="2024-12-31"
                                        class="data select form-control" value="<?php echo $tarefas['dataExecucaoFinal'] ?>"
                                        name="dataExecucaoFinal" autocomplete="off" required>
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
                                <input type="button" id="startAlterarButton" class="btn btn-success" value="Start" />
                                <input type="submit" name="submit" id="submit" class="btn btn-warning" value="Atualizar Tarefa" />
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
                                    <label class='control-label' for='inputNormal'>Status</label>
                                    <input type="hidden" class="form-control" name="idTipoOcorrencia"
                                        value="<?php echo $demanda['idTipoOcorrencia'] ?>">
                                    <input type="text" class="form-control" value="<?php echo $demanda['nomeTipoOcorrencia'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="labelForm">Data de Início</label>
                                    <input type="datetime-local" min="2022-01-01" max="2024-12-31"
                                        class="data select form-control" name="dataExecucaoInicio" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="labelForm">Data de Fim</label>
                                    <input type="datetime-local" min="2022-01-01" max="2024-12-31"
                                        class="data select form-control" name="dataExecucaoFinal" autocomplete="off"
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
                            <td class="text-center"><?php echo $tarefas['idTarefa'] ?></td>
                                    <td class="text-center"><?php echo $tarefas['tituloTarefa'] ?></td>
                                    <td class="text-center"><?php echo $tarefas['nomeUsuario'] ?></td>
                                    <td class="text-center"><?php echo $tarefas['nomeTipoOcorrencia'] ?></td>
                                    <?php
                                    $data = $tarefas['dataExecucaoInicio'];
                                    if ($data != null) {
                                        $data = date('d/m/Y', strtotime($data));
                                    } else {
                                        $data = "00/00/0000";
                                    } ?>
                                    <td class="text-center"><?php echo $data ?></td>
                                    <?php
                                    $dataExecucaoInicio = $tarefas['dataExecucaoInicio'];
                                    if ($dataExecucaoInicio != null) {
                                        $dataExecucaoInicio = date('H:i', strtotime($dataExecucaoInicio));
                                    } else {
                                        $dataExecucaoInicio = "00:00";
                                    }?>
                                    <td class="text-center"><?php echo $dataExecucaoInicio ?></td>
                                    <?php
                                    $dataExecucaoFinal = $tarefas['dataExecucaoFinal'];
                                    if ($dataExecucaoFinal != null) {
                                        $dataExecucaoFinal = date('H:i', strtotime($dataExecucaoFinal));
                                    } else {
                                        $dataExecucaoFinal = "00:00";
                                    }?>
                                    <td class="text-center"><?php echo $dataExecucaoFinal ?></td>
                                    <td class="text-center"><?php echo $tarefas['tempo'] ?></td>
                                    <?php
                                    $dataStart = $tarefas['dataStart'];
                                    if ($dataStart != null) {
                                        $dataStart = date('d/m/Y H:i', strtotime($dataStart));
                                    } else {
                                        $dataStart = "00/00/0000 00:00";
                                    }?>
                                    <td class="text-center"><?php echo $dataStart ?></td>
                                    <?php
                                    $dataStop = $tarefas['dataStop'];
                                    if ($dataStop != null) {
                                        $dataStop = date('H:i', strtotime($dataStop));
                                    } else {
                                        $dataStop = "00:00";
                                    } ?>
                                    <td class="text-center"><?php echo $dataStop ?></td>
                                    <td class="text-center"><?php echo $tarefas['duracao'] ?></td>
                                <td class="text-center">
                                    <?php if ($dataStart != null && $dataStop == "00:00") { ?>
                                        <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop" data-id="<?php echo $tarefas['idTarefa'] ?>" data-data-execucao="<?php echo $tarefas['dataStart'] ?>" />
                                    <?php } ?>
                                    <a class="btn btn-primary btn-sm" href="visualizar_tarefa.php?idTarefa=<?php echo $tarefas['idTarefa'] ?>&idDemanda=<?php echo $idDemanda ?>" role="button">Alterar</a>
                                </td>
                            </tr>
                        <?php } else {
                            foreach ($tarefas as $tarefa) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $tarefa['idTarefa'] ?></td>
                                    <td class="text-center"><?php echo $tarefa['tituloTarefa'] ?></td>
                                    <td class="text-center"><?php echo $tarefa['nomeUsuario'] ?></td>
                                    <td class="text-center"><?php echo $tarefa['nomeTipoOcorrencia'] ?></td>
                                    <?php
                                    $data = $tarefa['dataExecucaoInicio'];
                                    if ($data != null) {
                                        $data = date('d/m/Y', strtotime($data));
                                    }else {
                                        $data = "00/00/0000";
                                    } ?>
                                    <td class="text-center"><?php echo $data ?></td>
                                    <?php
                                    $dataExecucaoInicio = $tarefa['dataExecucaoInicio'];
                                    if ($dataExecucaoInicio != null) {
                                        $dataExecucaoInicio = date('H:i', strtotime($dataExecucaoInicio));
                                    } else {
                                        $dataExecucaoInicio = "00:00";
                                    }?>
                                    <td class="text-center"><?php echo $dataExecucaoInicio ?></td>
                                    <?php
                                    $dataExecucaoFinal = $tarefa['dataExecucaoFinal'];
                                    if ($dataExecucaoFinal != null) {
                                        $dataExecucaoFinal = date('H:i', strtotime($dataExecucaoFinal));
                                    } else {
                                        $dataExecucaoFinal = "00:00";
                                    }?>
                                    <td class="text-center"><?php echo $dataExecucaoFinal ?></td>
                                    <td class="text-center"><?php echo $tarefa['tempo'] ?></td>
                                    <?php
                                    $dataStart = $tarefa['dataStart'];
                                    if ($dataStart != null) {
                                        $dataStart = date('d/m/Y H:i', strtotime($dataStart));
                                    } else {
                                        $dataStart = "00/00/0000 00:00";
                                    }?>
                                    <td class="text-center"><?php echo $dataStart ?></td>
                                    <?php
                                    $dataStop = $tarefa['dataStop'];
                                    if ($dataStop != null) {
                                        $dataStop = date('H:i', strtotime($dataStop));
                                    } else {
                                        $dataStop = "00:00";
                                    } ?>
                                    <td class="text-center"><?php echo $dataStop ?></td>
                                    <td class="text-center"><?php echo $tarefa['duracao'] ?></td>
                                    <td class="text-center">
                                        <?php if ($dataStart != "00/00/0000 00:00" && $dataStop == "00:00") { ?>
                                            <input type="button" class="stopButton btn btn-danger btn-sm" value="Stop" data-id="<?php echo $tarefa['idTarefa'] ?>" data-data-execucao="<?php echo $tarefa['dataStart'] ?>" />
                                        <?php } ?>
                                        <a class="btn btn-primary btn-sm" href="visualizar_tarefa.php?idTarefa=<?php echo $tarefa['idTarefa'] ?>&idDemanda=<?php echo $idDemanda ?>" role="button">Alterar</a>
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
                var dataExecucaoInicio = $(this).data('data-execucao');
                var form_data = { idTarefa: idTarefa, dataExecucaoInicio: dataExecucaoInicio };
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