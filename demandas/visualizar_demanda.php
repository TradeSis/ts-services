<?php
//lucas 22092023 ID 358 Demandas/Comentarios 
include_once '../head.php';
$statusEncerrar = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_PAUSADO,
    TIPOSTATUS_RETORNO,
    TIPOSTATUS_RESPONDIDO,
    TIPOSTATUS_AGENDADO
);
?>

<body class="bg-transparent">

    <div class="container-fluid mb-3">
        <?php if ($ClienteSession == NULL) { ?>
            <form action="../database/demanda.php?operacao=alterar" method="post" id="form">
                <div class="row" style="margin-right:1px;">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>Prioridade</label>
                            <input type="number" min="1" max="99" class="form-control" name="prioridade" value="<?php echo $demanda['prioridade'] ?>" style="margin-top: 50px;">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>ID</label>
                            <input type="text" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly style="margin-top: 50px;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>Demanda</label>
                            <input type="text" class="form-control" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>" style="margin-top: 50px;">
                            <input type="text" class="form-control" name="idContratoTipo" value="<?php echo $demanda['idContratoTipo'] ?>" style="display: none">
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top:36px;">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>Solicitante</label>
                            <input type="text" class="data select form-control" name="idSolicitante" value="<?php echo $demanda['nomeSolicitante'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: -30px;">
                    <div class="col-md-6">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Descrição</span>
                            </div>
                            <div class="quill-textarea"><?php echo $demanda['descricao'] ?></div>
                            <textarea style="display: none" id="quill-descricao" name="descricao"><?php echo $demanda['descricao'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="col-md-12 form-group">
                            <label class="labelForm">Atualização Atendente</label>
                            <?php
                            $dataCobradoAtualizacaoAtendente = $demanda['dataAtualizacaoAtendente'];
                            if ($dataCobradoAtualizacaoAtendente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoAtendente != null) {
                                $dataCobradoAtualizacaoAtendente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoAtendente));
                            }
                            ?>
                            <input type="text" class="data select form-control" name="dataAtualizacaoAtendente" value="<?php echo $dataCobradoAtualizacaoAtendente ?>" readonly>
                            <label class='control-label' for='inputNormal'>Data de Abertura</label>
                            <input type="text" class="data select form-control" name="dataabertura" value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -20px;">

                            <label class="labelForm">Tempo Cobrado</label>
                            <input type="text" class="data select form-control" value="<?php echo $horas['totalHoraCobrado'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -20px;">
                            <label class="labelForm">Quantidade Retornos</label>
                            <input type="text" class="data select form-control" value="<?php echo $demanda['QtdRetornos'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Previsão</label>
                            <input type="number" class="data select form-control" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
                        </div>
                        <div class="col-md-12 form-group-select" style="margin-top: -29px;">
                            <label class="labelForm">Tamanho</label>
                            <select class="select form-control" name="tamanho">
                                <option value="<?php echo $demanda['tamanho'] ?>"><?php echo $demanda['tamanho'] ?>
                                </option>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="G">G</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group-select" style="margin-top: 20px;">
                            <label class="labelForm">Responsável</label>
                            <select class="select form-control" name="idAtendente">
                                <option value="<?php echo $demanda['idAtendente'] ?>"><?php echo $demanda['nomeAtendente'] ?></option>
                                <?php foreach ($atendentes as $atendente) { ?>
                                    <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="col-md-12 form-group">
                            <label class="labelForm">Atualização Cliente</label>
                            <?php
                            $dataCobradoAtualizacaoCliente = $demanda['dataAtualizacaoCliente'];
                            if ($dataCobradoAtualizacaoCliente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoCliente != null) {
                                $dataCobradoAtualizacaoCliente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoCliente));
                            }
                            ?>
                            <input type="text" class="data select form-control" name="dataAtualizacaoCliente" value="<?php echo $dataCobradoAtualizacaoCliente ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -24px;">
                            <label class="labelForm">Data Fim</label>
                            <?php
                            $dataCobradoFechamento = $demanda['dataFechamento'];
                            if ($dataCobradoFechamento != "0000-00-00 00:00:00" && $dataCobradoFechamento != null) {
                                $dataCobradoFechamento = date('d/m/Y H:i', strtotime($dataCobradoFechamento));
                            }
                            ?>
                            <input type="text" class="data select form-control" name="dataFechamento" value="<?php echo $dataCobradoFechamento ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -20px;">
                            <label class="labelForm">Tempo Real</label>
                            <input type="text" class="data select form-control" value="<?php echo $horas['totalHorasReal'] ?>" readonly>
                        </div>

                        <div class="col-md-12 form-group" style="margin-top: -20px;">
                            <label class="labelForm">Status</label>
                            <input type="text" class="data select form-control" value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group-select" style="margin-top: -25px;">
                            <label class="labelForm">Ocorrência</label>
                            <select class="select form-control" name="idTipoOcorrencia" autocomplete="off">
                                <option value="<?php echo $demanda['idTipoOcorrencia'] ?>"><?php echo $demanda['nomeTipoOcorrencia'] ?></option>
                                <?php foreach ($ocorrencias as $ocorrencia) { ?>
                                    <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group-select" style="margin-top: 15px; margin-bottom: 10px">
                            <label class="labelForm">Serviço</label>
                            <select class="select form-control" name="idServico" autocomplete="off">
                                <option value="<?php echo $demanda['idServico'] ?>"><?php echo $demanda['nomeServico'] ?>
                                </option>
                                <?php foreach ($servicos as $servico) { ?>
                                    <option value="<?php echo $servico['idServico'] ?>"><?php echo $servico['nomeServico'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group-select" style="margin-top: 10px; margin-bottom: 10px">
                            <label class="labelForm">Contrato Vinculado</label>
                            <select class="select form-control" name="idContrato" autocomplete="off">
                                <option value="<?php echo $demanda['idContrato'] ?>"><?php echo $demanda['tituloContrato'] ?></option>
                                <?php foreach ($contratos as $contrato) { ?>
                                    <option value="<?php echo $contrato['idContrato'] ?>"><?php echo $contrato['tituloContrato'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 mb-5">

                    <div class="col-md-6">
                        <?php
                        if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO) { ?>
                        <!-- lucas 22092023 ID 358 Modificado nome da chamada do modal e do botão para encerrar-->
                            <button type="button" data-toggle="modal" data-target="#encerrarModal" class="btn btn-danger" style="margin-right:10px;float: left;">Encerrar</button>
                        <?php }
                        if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO || $demanda['idTipoStatus'] == TIPOSTATUS_VALIDADO) { ?>
                        <!-- lucas 22092023 ID 358 Modificado nome da chamada do modal e do botão para reabrir-->
                            <button type="button" data-toggle="modal" data-target="#reabrirModal" class="btn btn-warning" style="margin-right:10px;float: left;">Reabrir</button>
                        <?php } ?>
                        <?php
                        if ($ClienteSession == NULL) { ?>

                            <button type="button" data-toggle="modal" data-target="#encaminharModal" class="btn btn-warning" style="margin-right:10px;float: left;">Encaminhar</button>
                        <?php } ?>

                        <?php if (in_array($demanda['idTipoStatus'], $statusEncerrar)) { ?>
                            <!-- lucas 22092023 ID 358 Modificado nome da chamada do modal e do botão para entregar-->
                            <button type="button" data-toggle="modal" data-target="#entregarModal" class="btn btn-warning mr-3">Entregar</button>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 text-right">

                        <input type="submit" name="submit" id="submit" class="btn btn-success" value="Atualizar" />
                    </div>
                </div>
            </form>
        <?php }
        //************* VISÃO CLIENTE *************
        else { ?>
            <form action="../database/demanda.php?operacao=alterar" method="post" id="form">
                <div class="row" style="margin-right:1px;">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>Prioridade</label>
                            <input type="number" min="1" max="99" class="form-control" name="prioridade" value="<?php echo $demanda['prioridade'] ?>" style="margin-top: 50px;">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>ID</label>
                            <input type="text" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly style="margin-top: 50px;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>Demanda</label>
                            <input type="text" class="form-control" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>" style="margin-top: 50px;">
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top:36px;">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal'>Solicitante</label>
                            <input type="text" class="data select form-control" name="idSolicitante" value="<?php echo $demanda['nomeSolicitante'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: -30px;">
                    <div class="col-md-6">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Descrição</span>
                            </div>
                            <div class="quill-textarea"><?php echo $demanda['descricao'] ?></div>
                            <textarea style="display: none" id="quill-descricao" name="descricao"><?php echo $demanda['descricao'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="col-md-12 form-group">
                            <label class="labelForm">Atualização Atendente</label>
                            <?php
                            $dataCobradoAtualizacaoAtendente = $demanda['dataAtualizacaoAtendente'];
                            if ($dataCobradoAtualizacaoAtendente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoAtendente != null) {
                                $dataCobradoAtualizacaoAtendente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoAtendente));
                            }
                            ?>
                            <input type="text" class="data select form-control" name="dataAtualizacaoAtendente" value="<?php echo $dataCobradoAtualizacaoAtendente ?>" readonly>
                            <label class='control-label' for='inputNormal'>Data de Abertura</label>
                            <input type="text" class="data select form-control" name="dataabertura" value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -20px;">

                            <label class="labelForm">Tempo Cobrado</label>
                            <input type="text" class="data select form-control" value="<?php echo $horas['totalHoraCobrado'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -20px;">
                            <label class="labelForm">Quantidade Retornos</label>
                            <input type="text" class="data select form-control" value="<?php echo $demanda['QtdRetornos'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Previsão</label>
                            <input type="number" class="data select form-control" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Tamanho</label>
                            <input type="text" class="data select form-control" name="tamanho" value="<?php echo $demanda['tamanho'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Responsável</label>
                            <input type="text" class="data select form-control" name="idAtendente" value="<?php echo $demanda['idAtendente'] ?>" readonly><?php echo $demanda['nomeAtendente'] ?></input>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="col-md-12 form-group">
                            <label class="labelForm">Atualização Cliente</label>
                            <?php
                            $dataCobradoAtualizacaoCliente = $demanda['dataAtualizacaoCliente'];
                            if ($dataCobradoAtualizacaoCliente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoCliente != null) {
                                $dataCobradoAtualizacaoCliente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoCliente));
                            }
                            ?>
                            <input type="text" class="data select form-control" name="dataAtualizacaoCliente" value="<?php echo $dataCobradoAtualizacaoCliente ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -24px;">
                            <label class="labelForm">Data Fim</label>
                            <?php
                            $dataCobradoFechamento = $demanda['dataFechamento'];
                            if ($dataCobradoFechamento != "0000-00-00 00:00:00" && $dataCobradoFechamento != null) {
                                $dataCobradoFechamento = date('d/m/Y H:i', strtotime($dataCobradoFechamento));
                            }
                            ?>
                            <input type="text" class="data select form-control" name="dataFechamento" value="<?php echo $dataCobradoFechamento ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -20px;">
                            <label class="labelForm">Tempo Real</label>
                            <input type="text" class="data select form-control" value="<?php echo $horas['totalHorasReal'] ?>" readonly>
                        </div>

                        <div class="col-md-12 form-group" style="margin-top: -20px;">
                            <label class="labelForm">Status</label>
                            <input type="text" class="data select form-control" value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Ocorrência</label>
                            <input type="text" class="data select form-control" value="<?php echo $demanda['nomeTipoOcorrencia'] ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Serviço</label>
                            <input type="text" class="data select form-control" name="idServico" value="<?php echo $demanda['idServico'] ?>" readonly><?php echo $demanda['nomeServico'] ?></input>
                        </div>
                        <div class="col-md-12 form-group" style="margin-top: -25px;">
                            <label class="labelForm">Contrato Vinculado</label>
                            <input type="text" class="data select form-control" name="idContrato" value="<?php echo $demanda['idContrato'] ?>" readonly><?php echo $demanda['tituloContrato'] ?></input>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 mb-5">

                    <div class="col-md-6">
                        <?php if ($ClienteSession >= 1) { ?>
                            <!-- lucas 22092023 ID 358 Modificado nome da chamada dos modais e dos botôes para encerrar e reabrir, adicionado condição para botão reabrir-->
                            <button type="button" data-toggle="modal" data-target="#encerrarModal" class="btn btn-danger" style="margin-right:10px;float: left;">Encerrar</button>
                            <?php if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO) { ?>
                            <button type="button" data-toggle="modal" data-target="#reabrirModal" class="btn btn-warning" style="margin-right:10px;float: left;">Reabrir</button>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 text-right">

                        <input type="submit" name="submit" id="submit" class="btn btn-success" value="Atualizar" />
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>


    <script>
        var quilldescricao = new Quill('.quill-textarea', {
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
            $('#quill-descricao').val(quilldescricao.container.firstChild.innerHTML);
        });
    </script>
</body>