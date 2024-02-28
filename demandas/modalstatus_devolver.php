   <!--------- MODAL DEVOLVER --------->
   <div class="modal" id="devolverModal" tabindex="-1" role="dialog" aria-labelledby="devolverModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                   <h5 class="modal-title" id="exampleModalLabel">Devolver chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form method="post">
                       <div class="container-fluid p-0">
                        <!-- lucas 27022024 - id853 nova chamada editor quill -->
                           <div id="ql-toolbarDevolver">
                               <?php include ROOT."/sistema/quilljs/ql-toolbar-min.php"  ?>
                               <input type="file" id="anexarDevolver" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileDevolver()" style=" display:none">
                               <label for="anexarDevolver">
                                   <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                               </label>
                           </div>
                           <div id="ql-editorDevolver" style="height:30vh !important">
                           </div>
                           <textarea style="display: none" id="quill-devolver" name="comentario"></textarea>
                       </div>
                       <div class="col-md">
                           <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                           <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                           <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                           <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>" readonly>
                       </div>
               </div>
               <div class="modal-footer">
                   <!-- lucas 22092023 ID 358 Modificado nome do botao-->
                   <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=devolver" class="btn btn-warning">Devolver</button>
               </div>
               </form>
           </div>
       </div>
   </div>

   <!-- lucas 27022024 - id853 nova chamada editor quill -->
   <script src="modalstatus.js"></script>