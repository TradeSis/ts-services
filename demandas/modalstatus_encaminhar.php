<!--------- MODAL ENCAMINHAR --------->
<div class="modal" id="encaminharModal" tabindex="-1" role="dialog" aria-labelledby="encaminharModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $demanda['tituloDemanda'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="container-fluid p-0">
                        <div class="col">
                            <span class="tituloEditor">Comentários</span>
                        </div>
                        <!-- lucas 27022024 - id853 nova chamada editor quill -->
                        <div id="ql-toolbarEncaminhar">
                            <?php include "quilljs/ql-toolbar-min.php"  ?>
                            <input type="file" id="anexarEncaminhar" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileEncaminhar()" style=" display:none">
                            <label for="anexarEncaminhar">
                                <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                            </label>
                        </div>
                        <div id="ql-editorEncaminhar" style="height:30vh !important">
                        </div>
                        <textarea style="display: none" id="quill-encaminhar" name="comentario"></textarea>
                    </div>
                    <div class="col-md">
                        <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
                        <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>">
                        <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>">
                        <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label class='form-label ts-label'>Reponsável</label>
                        <select class="form-select ts-input" name="idAtendente">
                            <?php
                            foreach ($atendentes as $atendente) {
                            ?>
                                <option <?php
                                        if ($atendente['idUsuario'] == $demanda['idAtendente']) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=encaminhar" class="btn btn-warning">Encaminhar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- lucas 27022024 - id853 nova chamada editor quill -->
<script src="modalstatus.js"></script>