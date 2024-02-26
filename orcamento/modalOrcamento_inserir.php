 <!--------- MODAL DEMANDA INSERIR --------->
 <div class="modal" id="novoinserirOrcamentoModal" tabindex="-1" aria-labelledby="novoinserirOrcamentoModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Inserir Orçamento</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form method="post" id="modalOrcamentoInserir">
                    <div class="row">
                        <div class="col-md-12">
                            <label class='form-label ts-label'>Titulo</label>
                            <input type="text" class="form-control ts-input" name="tituloContrato" required>
                            <input type="hidden" class="form-control ts-input" name="idContratoTipo" value="<?php echo $contratoTipo['idContratoTipo'] ?>">
                        </div>
                    </div>

                    <div class="col">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Descrição</span>
                            </div>
                            <div class="quill-orcamentoinserir" style="height:30vh !important"></div>
                            <textarea style="display: none" id="quill-orcamentoinserir" name="descricao"></textarea>
                        </div>
                    </div><!--col-md-6-->

                    <div class="row mt-2">
                        <div class="col-md-4 form-group-select">
                            <label class="form-label ts-label">Status</label>
                            <select class="form-select ts-input" name="idContratoStatus">
                                <?php
                                foreach ($orcamentosStatus as $orcamentoStatus) {
                                ?>
                                    <option <?php
                                            if ($orcamentoStatus['idOrcamentoStatus'] == $statusOrcamento) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $orcamentoStatus['idOrcamentoStatus'] ?>"><?php echo $orcamentoStatus['nomeOrcamentoStatus']  ?></option>
                                <?php  } ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label ts-label">Abertura</label>
                            <input type="date" class="form-control ts-input" name="dataAbertura">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label ts-label">Aprovação</label>
                            <input type="date" class="form-control ts-input" name="dataAprovacao">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3 ">
                            <label class="form-label ts-label">Cliente</label>
                            <select class="form-select ts-input" name="idCliente">
                                <?php
                                foreach ($clientes as $cliente) { // ABRE o 
                                ?>
                                    <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                                <?php  } ?> <!--FECHA while-->
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class='form-label ts-label'>Horas</label>
                            <input type="number" class="form-control ts-input" name="horas" autocomplete="off">
                        </div>

                        <div class="col-md-3">
                            <label class='form-label ts-label'>Valor Hora</label>
                            <input type="number" class="form-control ts-input" name="valorHora" autocomplete="off">
                        </div>

                        <div class="col-md-3">
                            <label class='form-label ts-label'>Valor Orçamento</label>
                            <input type="number" class="form-control ts-input" name="valorOrcamento" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="text-end mt-4">
                            <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
                        </div>
                    </div>
             </form>
         </div>
     </div>
 </div>

 <!-- LOCAL PARA COLOCAR OS JS -->

 <?php include_once ROOT . "/vendor/footer_js.php"; ?>

 <script>
     //Envio form modalOrcamentoInserir
     $("#modalOrcamentoInserir").submit(function(event) {
        event.preventDefault();
         var formData = new FormData(this);
         $.ajax({
             url: "../database/orcamento.php?operacao=inserir",
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