    
    <style>
        .ts-disable{
            display: none;
        }
    </style>
    <!--------- MODAL DEMANDA INSERIR --------->
    <div class="modal" id="novoinserirDemandaModal" tabindex="-1" aria-labelledby="novoinserirDemandaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir
                        <?php echo $contratoTipo['nomeDemanda'] ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="modalDemandaInserir">
                        <div class="row mt-1">
                            <div class="col-sm-8 col-md">
                                <label class='form-label ts-label'><?php echo $contratoTipo['nomeDemanda'] ?></label>
                                <input type="text" class="form-control ts-input" name="tituloDemanda" autocomplete="off" required>
                                <input type="hidden" class="form-control ts-input" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
                                <input type="hidden" class="form-control ts-input" name="idContratoTipo" value="<?php echo $contratoTipo['idContratoTipo'] ?>" readonly>
                            </div>

                            <div class="col-sm-4 col-md">
                                <label class="form-label ts-label">Cliente</label>
                                <input type="hidden" class="form-control ts-input" name="idSolicitante" value="<?php echo $usuario['idUsuario'] ?>" readonly>

                                <?php if (isset($contrato)) { ?>
                                    <input type="text" class="form-control ts-input" value="<?php echo $contrato['nomeCliente'] ?>" readonly>
                                    <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $contrato['idCliente'] ?>" readonly>
                                <?php } else { ?>
                                    <select class="form-select ts-input" name="idCliente" autocomplete="off" 
                                        <?php if (isset($contrato)) { echo " disabled "; } ?>required>
                                        <option value="">
                                            <?php if (isset($contrato)) {
                                                echo $contrato['nomeCliente'];
                                            } else {
                                                echo "Selecione";
                                            } ?>
                                        </option>
                                        <?php
                                        foreach ($clientes as $cliente) {
                                        ?>
                                            <option value="<?php echo $cliente['idCliente'] ?>">
                                                <?php echo $cliente['nomeCliente'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="container-fluid p-0">
                                    <div class="col">
                                        <span class="tituloEditor">Descrição</span>
                                    </div>
                                    <div class="quill-demandainserir" style="height:20vh !important"></div>
                                    <textarea style="display: none" id="quill-demandainserir" name="descricao"></textarea>
                                </div>
                            </div><!--col-md-6-->

                            <div class="col-md-6">
                                <div class="row"> 
                                    <?php if (empty($contrato)) { ?>
                                        <div class="col-md-10">
                                            <label class="form-label ts-label">Desvincular Contrato</label>
                                        </div>
                                        <div class="col-sm-2 col-md-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="desvinculaContrato">
                                        </div>
                                        </div>
                                    <?php  } ?>    
                                    <div class="col-sm-12 col-md-12 mt-3">
                                        
                                        <?php
                                        if (isset($contrato)) { ?>
                                            <input type="text" class="form-control ts-input" value="<?php echo $contrato['tituloContrato'] ?>" readonly>
                                            <input type="hidden" class="form-control ts-input" name="idContrato" value="<?php echo $contrato['idContrato'] ?>" readonly>
                                        <?php } else { ?>
                                            <?php if ($contratoTipo['idContratoTipo'] == 'os') { ?>
                                                <select class="form-select ts-input" name="idContrato" autocomplete="off" required>
                                                <?php } else { ?>
                                                    <input type="hidden" class="form-control ts-input" id="contrato" name="idContrato" value="null" >
                                                    <select class="form-select ts-input" id="idContrato" name="idContrato" autocomplete="off">  
                                                    <?php } ?>
                                                    <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                                    <?php foreach ($contratos as $contrato) {  ?>
                                            
                                                        <option data-idcliente="<?php echo $contrato['idCliente'] ?>" value="<?php echo $contrato['idContrato'] ?>">
                                                            <?php echo $contrato['tituloContrato'] ?>
                                                        </option>
                                                    <?php } ?>
                                                    </select>
                                                <?php  } ?>
                                    </div>

                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-6 col-md-6">
                                        <label class="form-label ts-label">Previsão</label>
                                        <input type="time" class="form-control ts-input" name="horasPrevisao" value="<?php echo $demanda['horasPrevisao'] ?>">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="form-label ts-label">Ocorrência</label>
                                        <select class="form-select ts-input" name="idTipoOcorrencia" autocomplete="off">
                                            <option value="<?php echo null ?>">
                                                <?php echo "Selecione" ?>
                                            </option>
                                            <?php
                                            foreach ($tipoocorrencias as $tipoocorrencia) {
                                            ?>
                                                <option  value="<?php echo $tipoocorrencia['idTipoOcorrencia'] ?>">
                                                    <?php echo $tipoocorrencia['nomeTipoOcorrencia'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><!--fim row 1-->

                                <div class="row mt-3">
                                    <!-- lucas 21112023 ID 688 - removido campo tamanho -->
                                    <div class="col-sm-6 col-md-6">
                                        <label class="form-label ts-label">Serviço</label>
                                        <select class="form-select ts-input" name="idServico" autocomplete="off">
                                            <option value="<?php echo null ?>">
                                                <?php echo "Selecione" ?>
                                            </option>
                                            <?php foreach ($servicos as $servico) { ?>
                                                <option value="<?php echo $servico['idServico'] ?>">
                                                    <?php echo $servico['nomeServico'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <label class="form-label ts-label">Responsável</label>
                                        <select class="form-select ts-input" name="idAtendente">
                                            <option value="<?php echo null ?>">
                                                <?php echo "Selecione" ?>
                                            </option>
                                            <?php foreach ($atendentes as $atendente) { ?>
                                                <option <?php
                                                        if ($atendente['idUsuario'] == $usuario['idUsuario']) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $atendente['idUsuario'] ?>">
                                                    <?php echo $atendente['nomeUsuario'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><!--fim row 2-->

                                

                            </div><!--col-md-6-->


                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>


$('#desvinculaContrato').click(function() {
    //$("#txtAge").toggle(this.checked);
    $( "#idContrato" ).toggleClass( "ts-disable" );
    $("#idContrato").prop('disabled', true);
    $("#contrato").prop('disabled', false);
});
        

        //Select de Contrato Vinculado troca de acordo com o Select de Cliente
        var contratos = $('select[name="idContrato"] option');
        $('select[name="idCliente"]').on('change', function() {
            var idCliente = this.value;
            if (idCliente != "") {
                var novoSelect = contratos.filter(function() {
                    return $(this).data('idcliente') == idCliente;
                });
                $('select[name="idContrato"]').html(novoSelect);
            } else {
                $('select[name="idContrato"]').html(contratos);
            }

        });

        //Envio form modalDemandaInserir
        $("#modalDemandaInserir").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/demanda.php?operacao=inserir",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage,
            });
        });

        function refreshPage() {
            window.location.reload();
        }
    </script>