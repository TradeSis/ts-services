<!--------- MODAL ENCAMINHAR --------->
<div class="modal" id="encaminharModal" tabindex="-1" role="dialog" aria-labelledby="encaminharModalLabel" aria-hidden="true">
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
                        <div class="col">
                            <span class="tituloEditor">Comentários</span>
                        </div>
                        <div class="quill-encaminhar" style="height:20vh !important"></div>
                        <textarea style="display: none" id="quill-encaminhar" name="comentario" required></textarea>
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
                <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=solicitar" class="btn btn-warning">Encaminhar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    var quillencaminhar = new Quill('.quill-encaminhar', {
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

    quillencaminhar.on('text-change', function(delta, oldDelta, source) {
        $('#quill-encaminhar').val(quillencaminhar.container.firstChild.innerHTML);
    });
</script>