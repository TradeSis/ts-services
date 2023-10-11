<!-- Gabriel 06102023 ID 596 mudanças em agenda e tarefas -->

<!--------- ALTERAR --------->
<div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" role="dialog"
    aria-labelledby="alterarmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab"
                            aria-controls="basic" aria-selected="true">Dados Tarefa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab"
                            aria-controls="advanced" aria-selected="false">Mais Opções</a>
                    </li>
                </ul>
                <form method="post" id="alterarForm">
                    <div class="tab-content" id="myTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4" style="margin-top: 10px;">
                                        <div class="form-group">
                                            <label class="labelForm">Tarefa</label>
                                            <input type="text" class="data select form-control" id="titulo"
                                                name="tituloTarefa" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -10px;">
                                        <div class="form-group" id="demandaContainer">
                                            <label class="labelForm">ID/Demanda Relacionada</label>
                                            <input type="text" class="data select form-control" id="tituloDemanda"
                                                style="margin-top: 18px;" autocomplete="off" readonly>
                                            <select class="form-control" name="idDemandaSelect" id="idDemandaSelect">
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
                                    <input type="hidden" class="form-control" name="idTarefa" id="idTarefa" />
                                    <input type="hidden" class="form-control" name="tipoStatusDemanda"
                                        id="tipoStatusDemanda" />
                                    <input type="hidden" class="form-control" name="idDemanda" id="idDemanda" />
                                    <div class="col-md-4" style="margin-top: -10px;">
                                        <div class="form-group">
                                            <label class="labelForm">Cliente</label>
                                            <input type="text" class="data select form-control" id="nomeCliente"
                                                style="margin-top: 18px;" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -15px;">
                                        <div class="form-group">
                                            <label class="labelForm">Reponsável</label>
                                            <input type="hidden" class="data select form-control" id="idAtendente">
                                            <input type="text" class="data select form-control" id="nomeUsuario"
                                                readonly>
                                            <select class="form-control" name="idAtendenteSelect" id="idAtendenteSelect"
                                                style="margin-top: -8px;">
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class='control-label' for='inputNormal'>Ocorrência</label>
                                            <div class="form-group" style="margin-top: 20px;">
                                                <select class="form-control" name="idTipoOcorrencia" id="idTipoOcorrencia">
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
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -14px;">
                                        <div class="form-group">
                                            <label class="labelForm">Horas Cobrado</label>
                                            <input type="time" class="data select form-control" id="horaCobrado"
                                                name="horaCobrado" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -30px;">
                                        <div class="form-group">
                                            <label class="labelForm">Data Previsão</label>
                                            <input type="date" class="data select form-control" id="Previsto"
                                                name="Previsto" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -30px;">
                                        <div class="form-group">
                                            <label class="labelForm">Inicio</label>
                                            <input type="time" class="data select form-control" id="horaInicioPrevisto"
                                                name="horaInicioPrevisto" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -30px;">
                                        <div class="form-group">
                                            <label class="labelForm">Fim</label>
                                            <input type="time" class="data select form-control" id="horaFinalPrevisto"
                                                name="horaFinalPrevisto" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php if ($_SESSION['idCliente'] == null) { ?>
                                    <div class="col-md-4" style="margin-top: -30px;">
                                        <div class="form-group">
                                            <label class="labelForm">Data Real</label>
                                            <input type="date" class="data select form-control" id="dataReal"
                                                name="dataReal" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -30px;">
                                        <div class="form-group">
                                            <label class="labelForm">Inicio</label>
                                            <input type="time" class="data select form-control" id="horaInicioReal"
                                                name="horaInicioReal" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: -30px;">
                                        <div class="form-group">
                                            <label class="labelForm">Fim</label>
                                            <input type="time" class="data select form-control" id="horaFinalReal"
                                                name="horaFinalReal" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
                            <div class="container">
                                <div class="quill-descricao" style="height:20vh !important"></div>
                                <textarea style="display: none" id="descricao" id="descricao"
                                    name="descricao"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <a id="visualizarDemandaButton" class="btn btn-primary" style="float:left">Visualizar</a>
                        <button type="submit" id="stopButtonModal" class="btn btn-danger" data-toggle="modal"><i
                                class="bi bi-stop-circle"></i> Stop</button>
                        <button type="submit" id="startButtonModal" class="btn btn-success"><i
                                class="bi bi-play-circle"></i> Start</button>
                        <button type="submit" id="realizadoButtonModal" class="btn btn-info"><i
                                class="bi bi-check-circle"></i> Realizado</button>
                        <button type="submit" id="clonarButtonModal" class="btn btn-success">Clonar</button>
                        <button type="submit" id="atualizarButtonModal" class="btn btn-warning"><i
                                class='bi bi-pencil-square'></i> Atualizar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

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

    quilldescricao.on('text-change', function (delta, oldDelta, source) {
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
            success: function (data) {
                console.log(data);
                $('#idTarefa').val(data.idTarefa);
                $('#titulo').val(data.tituloTarefa);
                $('#idCliente').val(data.idCliente);
                $('#nomeCliente').val(data.nomeCliente);
                $('#idDemanda').val(data.idDemanda);
                $('#idDemandaSelect').val(data.idDemanda);
                $('#tituloDemanda').val(data.idDemanda + ' - ' + data.tituloDemanda);
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
                    $('#idAtendenteSelect').hide();
                    $('#nomeUsuario').show();
                } else {
                    $('#idAtendenteSelect').show();
                    $('#nomeUsuario').hide();
                }
                if (data.idDemanda !== null) {
                    $('#idDemandaSelect').hide();
                    $('#tituloDemanda').show();
                } else {
                    $('#idDemandaSelect').show();
                    $('#tituloDemanda').hide();
                }
                if (data.horaInicioReal !== null) {
                    $('#startButtonModal').hide();
                    $('#realizadoButtonModal').hide();
                    $('#stopButtonModal').show();
                    $('#clonarButtonModal').hide();
                } 
                if (data.horaInicioReal == null) {
                    $('#startButtonModal').show();
                    $('#realizadoButtonModal').show();
                    $('#stopButtonModal').hide();
                    $('#clonarButtonModal').hide();
                } 
                if (data.horaInicioReal !== null && data.horaFinalReal !== null) {
                    $('#startButtonModal').hide();
                    $('#realizadoButtonModal').hide();
                    $('#stopButtonModal').hide();
                    $('#clonarButtonModal').show();
                } 

                $('#alterarmodal').modal('show');
            }
        });
    }
    $(document).on('click', 'button[data-target="#alterarmodal"]', function () {
        var idTarefa = $(this).attr("data-idtarefa");
        BuscarAlterar(idTarefa);
    });

    // Click event for tr[data-target="#alterarmodal"]
    $(document).on('click', 'td[data-target="#alterarmodal"]', function () {
        var idTarefa = $(this).attr("data-idtarefa");
        BuscarAlterar(idTarefa);
    });
</script>

