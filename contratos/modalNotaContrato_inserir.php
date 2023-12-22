<!--------- INSERIR --------->
<div class="modal fade bd-example-modal-lg" id="inserirModalNotas" tabindex="-1"
    aria-labelledby="inserirModalNotasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserir Nota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="inserirFormNotaContrato">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="form-label ts-label">Tomador/Cliente</label>
                            <select class="form-select ts-input" name="idPessoaTomador">
                                <?php
                                foreach ($pessoas as $pessoa) {
                                    ?>
                                <option value="<?php echo $pessoa['idPessoa'] ?>">
                                    <?php echo $pessoa['nomePessoa'] ?>
                                </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" class="form-control ts-input" name="idContrato" value="<?php echo $idContrato ?>">
                        </div>
                        <div class="col-md-3">
                            <label class='form-label ts-label'>Competência</label>
                            <input type="date" class="form-control ts-input" name="dataCompetencia" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label ts-label">Município</label>
                            <select class="form-select ts-input" name="codMunicipio">
                                <?php
                                foreach ($cidades as $cidade) {
                                    ?>
                                <option value="<?php echo $cidade['codigoCidade'] ?>">
                                    <?php echo $cidade['nomeCidade'] ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class='form-label ts-label'>valorNota</label>
                            <input type="text" class="form-control ts-input" name="valorNota" autocomplete="off"
                                required>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <span class="tituloEditor">Descrição/Título Serviço</span>
                        </div>
                        <div class="quill-descricaoServicoinserir" style="height:20vh !important"></div>
                        <textarea style="display: none" id="quill-descricaoServicoinserir"
                            name="descricaoServico"></textarea>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <span class="tituloEditor">condicao</span>
                        </div>
                        <div class="quill-condicaoinserir" style="height:20vh !important"></div>
                        <textarea style="display: none" id="quill-condicaoinserir" name="condicao"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    var condicaoinserir = new Quill('.quill-condicaoinserir', {
        theme: 'snow'
    });
    condicaoinserir.on('text-change', function (delta, oldDelta, source) {
        $('#quill-condicaoinserir').val(condicaoinserir.container.firstChild.innerHTML);
    });

    var descricaoServicoinserir = new Quill('.quill-descricaoServicoinserir', {
        theme: 'snow'
    });
    descricaoServicoinserir.on('text-change', function (delta, oldDelta, source) {
        $('#quill-descricaoServicoinserir').val(descricaoServicoinserir.container.firstChild.innerHTML);
    });
</script>