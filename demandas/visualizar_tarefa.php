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
$demanda = buscaDemandas($idDemanda);
$atendentes = buscaAtendente();
$cliente = buscaClientes($demanda["idCliente"]);
$tarefas = buscaTarefas($idDemanda);

?>

<body class="bg-transparent">
    <div class="container-fluid full-width mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="comentarios.php?idDemanda=<?php echo $idDemanda ?>">Comentarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" style="color:blue" href="visualizar_tarefa.php?idDemanda=<?php echo $idDemanda ?>">Tarefas</a>
            </li>
        </ul>
        <div class="card">
            <div class="container-fluid mt-1 mb-3">
                <form method="post" id="form1">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            
                                <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
                                <div class="for-group" style="margin-top: 22px;">
                                    <input type="text" class="form-control" name="tituloTarefa" autocomplete="off">
                                </div>
                            
                        </div>

                        <div class="col-md-6 form-group">
                            
                                <label class='control-label' for='inputNormal' style="margin-top: 10px;">ID/Demanda Relacionada</label>
                                <div class="for-group"style="margin-top: 22px;">
                                    <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" style="margin-bottom: -20px;">
                                    <input type="text" class="form-control" value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>" readonly>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Cliente</label>
                                <?php
                                ?>
                                <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>">
                                <input type="text" class="form-control" value="<?php echo $cliente['nomeCliente'] ?>" readonly>

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
                                        ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario']  ?></option>
                                <?php  } ?>
								</select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class='control-label' for='inputNormal'>Status</label>
                                <input type="hidden" class="form-control" name="idStatus" value="<?php echo $demanda['idTipoStatus'] ?>">
                                <input type="text" class="form-control" value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label class="labelForm">Data de Início</label>
                                <input type="datetime-local" min="2022-01-01" max="2024-12-31" class="data select form-control" name="dataExecucaoInicio" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label class="labelForm">Data de Fim</label>
                                <input type="datetime-local" min="2022-01-01" max="2024-12-31" class="data select form-control" name="dataExecucaoFinal" autocomplete="off" required> 
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <input type="submit" name="submit" id="submit" class="btn btn-info" value="Inserir Tarefa" />
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-2"> 
            <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
                <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Cliente</th>
                    <th>Demanda</th>
                    <th>Atendente</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Duração</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                    <tbody class="fonteCorpo">                           
                        <?php
                        if (count($tarefas) == 13) {;?>
                            <tr>
                                <td><?php echo $tarefas['idTarefa'] ?></td>
                                <td><?php echo $tarefas['tituloTarefa'] ?></td>
                                <td><?php echo $tarefas['nomeCliente'] ?></td>
                                <td><?php echo $tarefas['tituloDemanda'] ?></td>
                                <td><?php echo $tarefas['nomeUsuario'] ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($tarefas['dataExecucaoInicio'])) ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($tarefas['dataExecucaoFinal'])) ?></td>
                                <td><?php echo $tarefas['tempo'] ?></td>
                                <td><?php echo $tarefas['nomeTipoStatus'] ?></td>
                            </tr>
                            <?php } else {

                        foreach ($tarefas as $tarefa) {
                        ?>
                        <tr>
                            <td><?php echo $tarefa['idTarefa'] ?></td>
                            <td><?php echo $tarefa['tituloTarefa'] ?></td>
                            <td><?php echo $tarefa['nomeCliente'] ?></td>
                            <td><?php echo $tarefa['tituloDemanda'] ?></td>
                            <td><?php echo $tarefa['nomeUsuario'] ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($tarefa['dataExecucaoInicio'])) ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($tarefa['dataExecucaoFinal'])) ?></td>
                            <td><?php echo $tarefa['tempo'] ?></td>
                            <td><?php echo $tarefa['nomeTipoStatus'] ?></td>
                        </tr>
                        <?php }} ?>
                    </tbody>  
                </table>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $('#form1').on('submit', function(event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: "../database/tarefas.php?operacao=inserir",
                    method: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: refreshPage()
                })
            });

            function refreshPage() {
                window.location.reload();
            }
        });

        function updateInput() {
            var comboBox = document.getElementById("myComboBox");
            var otherInput = document.getElementById("otherInput");
            if (comboBox.value === "other") {
                otherInput.style.display = "block";
            } else {
                otherInput.style.display = "none";
            }
        }
    </script>
</body>

</html>