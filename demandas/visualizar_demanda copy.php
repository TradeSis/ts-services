<?php
//lucas 22092023 ID 358 Demandas/Comentarios 
include_once '../header.php';
$statusEncerrar = array(
    TIPOSTATUS_FILA,
    TIPOSTATUS_PAUSADO,
    TIPOSTATUS_RETORNO,
    TIPOSTATUS_RESPONDIDO,
    TIPOSTATUS_AGENDADO
);
?>


    <div class="container-fluid mb-3">
        <?php if ($ClienteSession == NULL) { ?>
            <form action="../database/demanda.php?operacao=alterar" method="post" id="form">
                <div class="row mr-1">
                    <div class="col-md-1">
                            <label class='form-label ts-label'>Prioridade</label>
                            <input type="number" min="1" max="99" class="form-control ts-input" name="prioridade" value="<?php echo $demanda['prioridade'] ?>">
                    </div>
                    <div class="col-md-1">
                            <label class='form-label ts-label'>ID</label>
                            <input type="text" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                    </div>
                    <div class="col-md-8">
                            <label class='form-label ts-label'>Demanda</label>
                            <input type="text" class="form-control ts-input" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>">
                            <input type="hidden" class="form-control ts-input" name="idContratoTipo" value="<?php echo $demanda['idContratoTipo'] ?>">
                    </div>
                    <div class="col-md-2">
                            <label class='form-label ts-label'>Solicitante</label>
                            <input type="text" class="data select form-control ts-input" name="idSolicitante" value="<?php echo $demanda['nomeSolicitante'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Descrição</span>
                            </div>
                            <div class="quill-textarea"><?php echo $demanda['descricao'] ?></div>
                            <textarea style="display: none" id="quill-descricao" name="descricao"></textarea>
                        </div>

                        <!-- <textarea name="descricao" id="" cols="30" rows="10"><?php echo $demanda['descricao'] ?></textarea> -->
                    </div>
                    <div class="col-md">
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Atualização Atendente</label>
                            <?php
                            $dataCobradoAtualizacaoAtendente = $demanda['dataAtualizacaoAtendente'];
                            if ($dataCobradoAtualizacaoAtendente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoAtendente != null) {
                                $dataCobradoAtualizacaoAtendente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoAtendente));
                            }
                            ?>
                            <input type="text" class="form-control ts-input" name="dataAtualizacaoAtendente" value="<?php echo $dataCobradoAtualizacaoAtendente ?>" readonly>
                            <label class="form-label ts-label">Data de Abertura</label>
                            <input type="text" class="form-control ts-input" name="dataabertura" value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Tempo Cobrado</label>
                            <input type="text" class="form-control ts-input" value="<?php echo $horas['totalHoraCobrado'] ?>" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Quantidade Retornos</label>
                            <input type="text" class="form-control ts-input" value="<?php echo $demanda['QtdRetornos'] ?>" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Previsão</label>
                            <input type="number" class="form-control ts-input" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Tamanho</label>
                            <select class="form-select ts-input" name="tamanho">
                                <option value="<?php echo $demanda['tamanho'] ?>"><?php echo $demanda['tamanho'] ?>
                                </option>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="G">G</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Responsável</label>
                            <select class="form-select ts-input" name="idAtendente">
                                <option value="<?php echo $demanda['idAtendente'] ?>"><?php echo $demanda['nomeAtendente'] ?></option>
                                <?php foreach ($atendentes as $atendente) { ?>
                                    <option value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Atualização Cliente</label>
                            <?php
                            $dataCobradoAtualizacaoCliente = $demanda['dataAtualizacaoCliente'];
                            if ($dataCobradoAtualizacaoCliente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoCliente != null) {
                                $dataCobradoAtualizacaoCliente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoCliente));
                            }
                            ?>
                            <input type="text" class="form-control ts-input" name="dataAtualizacaoCliente" value="<?php echo $dataCobradoAtualizacaoCliente ?>" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Data Entrega</label>
                            <?php
                            $dataCobradoFechamento = $demanda['dataFechamento'];
                            if ($dataCobradoFechamento != "0000-00-00 00:00:00" && $dataCobradoFechamento != null) {
                                $dataCobradoFechamento = date('d/m/Y H:i', strtotime($dataCobradoFechamento));
                            }
                            ?>
                            <input type="text" class="form-control ts-input" name="dataFechamento" value="<?php echo $dataCobradoFechamento ?>" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Tempo Real</label>
                            <input type="text" class="form-control ts-input" value="<?php echo $horas['totalHorasReal'] ?>" readonly>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Status</label>
                            <input type="text" class="form-control ts-input" value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Ocorrência</label>
                            <select class="form-select ts-input" name="idTipoOcorrencia" autocomplete="off">
                                <option value="<?php echo $demanda['idTipoOcorrencia'] ?>"><?php echo $demanda['nomeTipoOcorrencia'] ?></option>
                                <?php foreach ($ocorrencias as $ocorrencia) { ?>
                                    <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Serviço</label>
                            <select class="form-select ts-input" name="idServico" autocomplete="off">
                                <option value="<?php echo $demanda['idServico'] ?>"><?php echo $demanda['nomeServico'] ?>
                                </option>
                                <?php foreach ($servicos as $servico) { ?>
                                    <option value="<?php echo $servico['idServico'] ?>"><?php echo $servico['nomeServico'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label ts-label">Contrato Vinculado</label>
                            <select class="form-select ts-input" name="idContrato" autocomplete="off">
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
                            <button type="button" data-bs-toggle="modal" data-bs-target="#encerrarModal" class="btn btn-danger" style="margin-right:10px;float: left;">Encerrar</button>
                        <?php }
                        if ($demanda['idTipoStatus'] == TIPOSTATUS_REALIZADO || $demanda['idTipoStatus'] == TIPOSTATUS_VALIDADO) { ?>
                        <!-- lucas 22092023 ID 358 Modificado nome da chamada do modal e do botão para reabrir-->
                            <button type="button" data-bs-toggle="modal" data-bs-target="#reabrirModal" class="btn btn-warning" style="margin-right:10px;float: left;">Reabrir</button>
                        <?php } ?>
                        <?php
                        if ($ClienteSession == NULL) { ?>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#encaminharModal" class="btn btn-warning" style="margin-right:10px;float: left;">Encaminhar</button>
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
                <div class="row mr-1">
                    <div class="col-md-1">
                            <label class='form-label ts-label'>Prioridade</label>
                            <input type="number" min="1" max="99" class="form-control ts-label" name="prioridade" value="<?php echo $demanda['prioridade'] ?>">
                    </div>
                    <div class="col-md-1">
                            <label class='form-label ts-label'>ID</label>
                            <input type="text" class="form-control ts-label" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                    </div>
                    <div class="col-md-8">
                            <label class='form-label ts-label'>Demanda</label>
                            <input type="text" class="form-control ts-label" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>">
                    </div>
                    <div class="col-md-2">
                            <label class='form-label ts-label'>Solicitante</label>
                            <input type="text" class="form-control ts-label" name="idSolicitante" value="<?php echo $demanda['nomeSolicitante'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-3">
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
                        <div class="col-md-12">
                            <label class="form-label ts-label">Atualização Atendente</label>
                            <?php
                            $dataCobradoAtualizacaoAtendente = $demanda['dataAtualizacaoAtendente'];
                            if ($dataCobradoAtualizacaoAtendente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoAtendente != null) {
                                $dataCobradoAtualizacaoAtendente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoAtendente));
                            }
                            ?>
                            <input type="text" class="form-control ts-label" name="dataAtualizacaoAtendente" value="<?php echo $dataCobradoAtualizacaoAtendente ?>" readonly>
                            <label class='form-label ts-label'>Data de Abertura</label>
                            <input type="text" class="form-control ts-label" name="dataabertura" value="<?php echo date('d/m/Y H:i', strtotime($demanda['dataAbertura'])) ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Tempo Cobrado</label>
                            <input type="text" class="form-control ts-label" value="<?php echo $horas['totalHoraCobrado'] ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Quantidade Retornos</label>
                            <input type="text" class="form-control ts-label" value="<?php echo $demanda['QtdRetornos'] ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Previsão</label>
                            <input type="number" class="form-control ts-label" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Tamanho</label>
                            <input type="text" class="form-control ts-label" name="tamanho" value="<?php echo $demanda['tamanho'] ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Responsável</label>
                            <input type="text" class="form-control ts-label" name="idAtendente" value="<?php echo $demanda['idAtendente'] ?>" readonly><?php echo $demanda['nomeAtendente'] ?></input>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="col-md-12">
                            <label class="form-label ts-label">Atualização Cliente</label>
                            <?php
                            $dataCobradoAtualizacaoCliente = $demanda['dataAtualizacaoCliente'];
                            if ($dataCobradoAtualizacaoCliente != "0000-00-00 00:00:00" && $dataCobradoAtualizacaoCliente != null) {
                                $dataCobradoAtualizacaoCliente = date('d/m/Y H:i', strtotime($dataCobradoAtualizacaoCliente));
                            }
                            ?>
                            <input type="text" class="form-control ts-label" name="dataAtualizacaoCliente" value="<?php echo $dataCobradoAtualizacaoCliente ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Data Entrega</label>
                            <?php
                            $dataCobradoFechamento = $demanda['dataFechamento'];
                            if ($dataCobradoFechamento != "0000-00-00 00:00:00" && $dataCobradoFechamento != null) {
                                $dataCobradoFechamento = date('d/m/Y H:i', strtotime($dataCobradoFechamento));
                            }
                            ?>
                            <input type="text" class="form-control ts-label" name="dataFechamento" value="<?php echo $dataCobradoFechamento ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Tempo Real</label>
                            <input type="text" class="form-control ts-label" value="<?php echo $horas['totalHorasReal'] ?>" readonly>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label ts-label">Status</label>
                            <input type="text" class="form-control ts-label" value="<?php echo $demanda['nomeTipoStatus'] ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Ocorrência</label>
                            <input type="text" class="form-control ts-label" value="<?php echo $demanda['nomeTipoOcorrencia'] ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Serviço</label>
                            <input type="text" class="form-control ts-label" name="idServico" value="<?php echo $demanda['idServico'] ?>" readonly><?php echo $demanda['nomeServico'] ?></input>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label ts-label">Contrato Vinculado</label>
                            <input type="text" class="form-control ts-label" name="idContrato" value="<?php echo $demanda['idContrato'] ?>" readonly><?php echo $demanda['tituloContrato'] ?></input>
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


</body>