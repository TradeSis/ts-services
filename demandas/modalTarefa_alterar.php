<!-- Gabriel 06102023 ID 596 mudanças em agenda e tarefas -->

<!--------- ALTERAR --------->
<div class="modal" id="alterarmodal" tabindex="-1"  aria-labelledby="alterarmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link ts-tabModal active" id="basic-tab" data-bs-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Dados Tarefa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ts-tabModal" id="advanced-tab" data-bs-toggle="tab" href="#advanced" role="tab" aria-controls="advanced" aria-selected="false">Mais Opções</a>
                    </li>
                </ul>
                <form method="post" id="alterarForm">
                    <div class="tab-content" id="myTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="container">

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class='form-label ts-label'>Tarefa</label>
                                        <input type="text" class="form-control ts-input" id="titulo" name="tituloTarefa" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <div id="demandaContainer">
                                            <label class="form-label ts-label">ID/Demanda Relacionada</label>
                                            <select class="form-select ts-input" name="idDemandaSelect" id="idDemandaSelect">
                                                <option value="null"></option>
                                                <?php
                                                foreach ($demandas as $demanda) {
                                                ?>
                                                    <option value="<?php echo $demanda['idDemanda'] ?>">
                                                        <?php echo $demanda['idDemanda'] . " - " . $demanda['tituloDemanda'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control ts-input" name="idTarefa" id="idTarefa" />
                                    <input type="hidden" class="form-control ts-input" name="tipoStatusDemanda" id="tipoStatusDemanda" />
                                    <input type="hidden" class="form-control ts-input" name="idDemanda" id="idDemanda" />

                                    <div class="col-md-4">
                                        <label class="form-label ts-label">Cliente</label>
                                        <input type="hidden" class="form-control ts-input" id="idCliente">
                                        <select class="form-select ts-input" name="idClienteSelect" id="idClienteSelect">
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
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">Reponsável</label>
                                        <input type="hidden" class="form-control ts-input" id="idAtendente">
                                        <select class="form-select ts-input" name="idAtendenteSelect" id="idAtendenteSelect">
                                            <?php
                                            foreach ($atendentes as $atendente) {
                                            ?>
                                                <option value="<?php echo $atendente['idUsuario'] ?>">
                                                    <?php echo $atendente['nomeUsuario'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class='form-label ts-label'>Ocorrência</label>
                                        <select class="form-select ts-input" name="idTipoOcorrencia" id="idTipoOcorrencia">
                                            <option value="null"></option>
                                            <?php
                                            foreach ($ocorrencias as $ocorrencia) {
                                            ?>
                                                <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                                                    <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">Horas Cobrado</label>
                                        <input type="time" class="form-control ts-input" id="horaCobrado" name="horaCobrado" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">Data Previsão</label>
                                        <input type="date" class="form-control ts-input" id="Previsto" name="Previsto" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">Inicio</label>
                                        <input type="time" class="form-control ts-input" id="horaInicioPrevisto" name="horaInicioPrevisto" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">Fim</label>
                                        <input type="time" class="form-control ts-input" id="horaFinalPrevisto" name="horaFinalPrevisto" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <?php if ($_SESSION['idCliente'] == null) { ?>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">Data Real</label>
                                            <input type="date" class="form-control ts-input" id="dataReal" name="dataReal" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">Inicio</label>
                                            <input type="time" class="form-control ts-input" id="horaInicioReal" name="horaInicioReal" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">Fim</label>
                                            <input type="time" class="form-control ts-input" id="horaFinalReal" name="horaFinalReal" autocomplete="off">
                                        </div>
                                    <?php } ?>
                                </div><!--row-->

                            </div>
                        </div>
                        <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
                            <div class="container">
                                <div class="quill-descricao" style="height:20vh !important"></div>
                                <textarea style="display: none" id="descricao" id="descricao" name="descricao"></textarea>
                            </div>
                        </div>
                    </div>

            </div><!--modal body-->
            <div class="modal-footer">
                <a id="visualizarDemandaButton" class="btn btn-primary">Visualizar</a>
                <button type="submit" id="stopButtonModal" class="btn btn-danger" data-toggle="modal"><i class="bi bi-stop-circle"></i> Stop</button>
                <button type="submit" id="startButtonModal" class="btn btn-success"><i class="bi bi-play-circle"></i> Start</button>
                <button type="submit" id="realizadoButtonModal" class="btn btn-info"><i class="bi bi-check-circle"></i> Realizado</button>
                <button type="submit" id="atualizarButtonModal" class="btn btn-warning"><i class='bi bi-pencil-square'></i> Atualizar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT . "/vendor/footer_js.php"; ?>


<script>
    var quilldescricao = new Quill('.quill-descricao', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                [{
                    'direction': 'rtl'
                }],
                [{
                    'size': ['small', false, 'large', 'huge']
                }],
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['link', 'image', 'video', 'formula'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],
            ]
        }
    });

    quilldescricao.on('text-change', function(delta, oldDelta, source) {
        $('#descricao').val(quilldescricao.container.firstChild.innerHTML);
    });

    function BuscarAlterar(idTarefa) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
            data: {
                idTarefa: idTarefa
            },
            success: function(data) {

                $('#idTarefa').val(data.idTarefa);
                $('#titulo').val(data.tituloTarefa);
                $('#idCliente').val(data.idCliente);
                $('#idClienteSelect').val(data.idCliente);
                $('#nomeCliente').val(data.nomeCliente);
                $('#idDemanda').val(data.idDemanda);
                $('#idAtendente').val(data.idAtendente);
                $('#idAtendenteSelect').val(data.idAtendente);
                $('#nomeUsuario').val(data.nomeUsuario);
                $('#idTipoOcorrencia').val(data.idTipoOcorrencia);
                $('#nomeTipoOcorrencia').val(data.nomeTipoOcorrencia);
                $('#Previsto').val(data.Previsto);
                $('#horaInicioPrevisto').val(data.horaInicioPrevisto);
                $('#horaFinalPrevisto').val(data.horaFinalPrevisto);
                $('#dataReal').val(data.dataReal);
                $('#horaInicioReal').val(data.horaInicioReal);
                $('#horaFinalReal').val(data.horaFinalReal);
                $('#horaCobrado').val(data.horaCobrado);
                $('#tipoStatusDemanda').val(data.idTipoStatus);
                quilldescricao.root.innerHTML = data.descricao;

                
                if (data.idDemanda !== null) {
                    var visualizarDemandaUrl = "visualizar.php?idDemanda=" + data.idDemanda;
                    $("#visualizarDemandaButton").attr("href", visualizarDemandaUrl);
                    $('#visualizarDemandaButton').show();
                } else {
                    $('#visualizarDemandaButton').hide();
                }
          
                if (data.Previsto !== null || data.dataReal !== null) {
                    //se vier dataPrevisto ou dataReal o select vai estar desabilitado
                    $("#idAtendenteSelect").prop('disabled', true);
                } else {
                    //senão vai habilitar o select
                    $("#idAtendenteSelect").prop('disabled', false);
                }

                if (data.idDemanda !== null) {
                    $('#idDemandaSelect').val(data.idDemanda);
                    $('#idDemandaSelect').attr('disabled', 'disabled');
                } else {
                    $('#idDemandaSelect').removeAttr('disabled');
                }
                if (data.horaInicioReal !== null) {
                    $('#startButtonModal').hide();
                    $('#realizadoButtonModal').hide();
                    $('#stopButtonModal').show();
                }
                if (data.horaInicioReal == null) {
                    $('#startButtonModal').show();
                    $('#realizadoButtonModal').show();
                    $('#stopButtonModal').hide();
                }
                if (data.horaInicioReal !== null && data.horaFinalReal !== null) {
                    $('#startButtonModal').hide();
                    $('#realizadoButtonModal').hide();
                    $('#stopButtonModal').hide();
                }
                if(data.idCliente == null){
                    //se idCliente vier nulo o select vai estar habilitado
                     $("#idClienteSelect").prop('disabled', false);
                }else{
                    //se idCliente vier Preenchido o select vai estar desabilitado
                    $("#idClienteSelect").prop('disabled', true);
                }

                $('#alterarmodal').modal('show');
            }
        });
    }
    $(document).on('click', 'button[data-target="#alterarmodal"]', function() {
        var idTarefa = $(this).attr("data-idtarefa");
        BuscarAlterar(idTarefa);
    });

    // Click event for tr[data-target="#alterarmodal"]
    $(document).on('click', 'td[data-target="#alterarmodal"]', function() {
        var idTarefa = $(this).attr("data-idtarefa");
        BuscarAlterar(idTarefa);
    });
    //gabriel 13102023 id 596 sempre abrir pagina 1 do modal 
    $(document).ready(function() {
        $('#alterarmodal').on('shown.bs.modal', function() {
            $('#basic-tab').tab('show');
        });
    });
</script>