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
                <a class="nav-link active" href="visualizar_tarefa.php?idDemanda=<?php echo $idDemanda ?>">Tarefas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" style="color:blue"
                    href="previsao.php?idDemanda=<?php echo $idDemanda ?>">Previsão</a>
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
                            <div class="col-md-3">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control"
                                        value="<?php echo $tarefas['dataPrevisto'] ?>" name="dataPrevisto"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control"
                                        value="<?php echo $tarefas['previsaoInicio'] ?>" name="previsaoInicio"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control"
                                        value="<?php echo $tarefas['previsaoFim'] ?>" name="previsaoFim" autocomplete="off"
                                        required>
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
                                <input type="submit" name="submit" id="submit" class="btn btn-warning"
                                    value="Atualizar Previsão" />
                            </div>
                        </div>
                    </form>
                <?php }
                //******************* Criar Tarefa *******************
                else { ?>
                    <form method="post" id="form1">
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label class='control-label' for='inputNormal'>ID/Demanda
                                    Relacionada</label>
                                <input type="hidden" class="form-control" name="idDemanda"
                                    value="<?php echo $demanda['idDemanda'] ?>">
                                <input type="text" class="form-control"
                                    value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>"
                                    readonly>
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Data Previsão</label>
                                    <input type="date" class="data select form-control" name="dataPrevisto"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Inicio</label>
                                    <input type="time" class="data select form-control" name="previsaoInicio"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="labelForm">Fim</label>
                                    <input type="time" class="data select form-control" name="previsaoFim"
                                        autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <input type="button" id="inserirButton" class="btn btn-info" value="Inserir Previsão" />
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
                                    <?php echo $tarefas['nomeUsuario'] ?>
                                </td>
                                <?php
                                if ($tarefas['dataPrevisto'] != null) {
                                    $dataPrevisto = date('d/m/Y', strtotime($tarefas['dataPrevisto']));
                                } else {
                                    $dataPrevisto = "Previsão não definida";
                                } ?>
                                <td class="text-center">
                                    <?php echo $dataPrevisto ?>
                                </td>
                                <?php
                                if ($tarefas['previsaoInicio'] != null) {
                                    $previsaoInicio = date('H:i', strtotime($tarefas['previsaoInicio']));
                                } else {
                                    $previsaoInicio = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $previsaoInicio ?>
                                </td>
                                <?php
                                if ($tarefas['previsaoFim'] != null) {
                                    $previsaoFim = date('H:i', strtotime($tarefas['previsaoFim']));
                                } else {
                                    $previsaoFim = "00:00";
                                } ?>
                                <td class="text-center">
                                    <?php echo $previsaoFim ?>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm"
                                        href="previsao.php?idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
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
                                        <?php echo $tarefa['nomeUsuario'] ?>
                                    </td>
                                    <?php
                                    if ($tarefa['dataPrevisto'] != null) {
                                        $dataPrevisto = date('d/m/Y', strtotime($tarefa['dataPrevisto']));
                                    } else {
                                        $dataPrevisto = "Previsão não definida";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $dataPrevisto ?>
                                    </td>
                                    <?php
                                    if ($tarefa['previsaoInicio'] != null) {
                                        $previsaoInicio = date('H:i', strtotime($tarefa['previsaoInicio']));
                                    } else {
                                        $previsaoInicio = "00:00";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $previsaoInicio ?>
                                    </td>
                                    <?php
                                    if ($tarefa['previsaoFim'] != null) {
                                        $previsaoFim = date('H:i', strtotime($tarefa['previsaoFim']));
                                    } else {
                                        $previsaoFim = "00:00";
                                    } ?>
                                    <td class="text-center">
                                        <?php echo $previsaoFim ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm"
                                            href="previsao.php?idTarefa=<?php echo $tarefa['idTarefa'] ?>&&idDemanda=<?php echo $idDemanda ?>"
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
                    url: "../database/tarefas.php?operacao=alterarPrevisao",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                });
            });


            $('#inserirButton').click(function () {
                var form_data = $('#form1').serialize();
                $.ajax({
                    url: "../database/tarefas.php?operacao=previsao",
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