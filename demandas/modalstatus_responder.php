   <!--------- MODAL RESPONDER --------->
   <div class="modal" id="responderModal" tabindex="-1" role="dialog" aria-labelledby="responderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Responder chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0">
                            <div class="col">
                                <span class="tituloEditor">Comentários</span>
                            </div>
                            <!-- lucas 22092023 ID 358 Modificado nome da classe do editor-->
                            <div class="quill-responder" style="height:20vh !important"></div>
                            <textarea style="display: none" id="quill-responder" name="comentario"></textarea>
                            <!-- -->
                        </div>
                        <div class="container-fluid p-0">
                           <div id="ql-toolbarResponder">
                               <?php include "quilljs/ql-toolbar-min.php"  ?>
                               <input type="file" id="anexarResponder" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileResponder()" style=" display:none">
                               <label for="anexarResponder">
                                   <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                               </label>
                           </div>
                           <div id="ql-editorResponder" style="height:30vh !important">
                           </div>
                           <textarea style="display: none" id="quill-responder" name="comentario"></textarea>
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
                    <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=responder" class="btn btn-warning">Responder</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="modalstatus.js"></script>

    <script>
        var quillresponder = new Quill('.quill-responder', {
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
        /* lucas 22092023 ID 358 Modificado nome da classe do editor */
        quillresponder.on('text-change', function(delta, oldDelta, source) {
            $('#quill-responder').val(quillresponder.container.firstChild.innerHTML);
        });
    </script>