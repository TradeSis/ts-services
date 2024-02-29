<!--------- MODAL ENTREGAR --------->
<div class="modal" id="entregarModal" tabindex="-1" role="dialog" aria-labelledby="entregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                <h5 class="modal-title" id="exampleModalLabel">Chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="container-fluid p-0">
                        <!-- lucas 27022024 - id853 nova chamada editor quill -->
                        <div id="ql-toolbarEntregar">
                            <?php include ROOT."/sistema/quilljs/ql-toolbar-min.php"  ?>
                            <input type="file" id="anexarEntregar" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileEntregar()" style=" display:none">
                            <label for="anexarEntregar">
                                <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                            </label>
                        </div>
                        <div id="ql-editorEntregar" style="height:30vh !important">
                        </div>
                        <textarea style="display: none" id="quill-entregar" name="comentario"></textarea>
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
                <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=entregar" class="btn btn-warning">Entregar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- lucas 27022024 - id853 nova chamada editor quill -->
<script src="modalstatus.js"></script>