 <!--------- INSERIR/AGENDAR --------->
 <div class="modal" id="inserirModal" tabindex="-1" role="dialog" aria-labelledby="inserirModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Inserir Tarefa</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <form method="post" id="inserirForm">
           <div class="row">
             <div class="col-md-6 form-group">
               <label class='control-label' for='inputNormal' style="margin-top: 10px;">Tarefa</label>
               <div class="for-group" style="margin-top: 22px;">
                 <input type="text" class="form-control" name="tituloTarefa" id="newtitulo" autocomplete="off" required>
               </div>
               <input type="hidden" class="form-control" name="idDemanda" value="null" id="newidDemanda">
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label class='control-label' for='inputNormal'>Cliente</label>
                 <div class="form-group" style="margin-top: 40px;">
                   <select class="form-control" name="idCliente" id="newidCliente">
                     <option value="null"></option>
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
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label class='control-label' for='inputNormal'>Reponsável</label>
                 <div class="form-group" style="margin-top: 20px;">
                   <select class="form-control" name="idAtendente" id="newidAtendente">
                     <!-- gabriel 13102023 id596 removido a possibilidade de adicionar tarefa sem responsável -->
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
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label class='control-label' for='inputNormal'>Ocorrência</label>
                 <div class="form-group" style="margin-top: 20px;">
                   <select class="form-control" name="idTipoOcorrencia" id="newidTipoOcorrencia">
                     <option value="null">Selecione</option>
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
             <div class="col-md-4">
               <div class="form-group">
                 <label class="labelForm">Data Previsão</label>
                 <input type="date" class="data select form-control" name="Previsto" autocomplete="off" required>
               </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <label class="labelForm">Inicio</label>
                 <input type="time" class="data select form-control" name="horaInicioPrevisto" autocomplete="off">
               </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <label class="labelForm">Fim</label>
                 <input type="time" class="data select form-control" name="horaFinalPrevisto" autocomplete="off">
               </div>
             </div>
           </div>
       </div><!--modal body-->
       <div class="modal-footer text-end">
         <button type="submit" class="btn btn-warning" id="inserirStartBtn">Start</button>
         <button type="submit" class="btn btn-success" id="inserirBtn">Inserir</button>
       </div>
       </form>

     </div>
   </div>
 </div>