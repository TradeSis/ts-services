
<div class="col text-end">


    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#descricaoModal">
        Editar
    </button>
</div>
<div class="container-fluid p-0 ts-containerDescricaoDemanda">
            <div class="row">
       
            <div class="quill-textarea ts-displayDisable" style="height: 30vh!important;"><?php echo $demanda['descricao'] ?></div>
            <textarea style="display: none" id="quill-descricao" name="descricao"><?php echo $demanda['descricao'] ?></textarea>
            <input type="hidden" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
        </div>

<!-- Modal -->
<div class="modal fade" id="descricaoModal" tabindex="-1" aria-labelledby="descricaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Descrição</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../database/demanda.php?operacao=descricao" method="post">
                    <div class="container-fluid p-0">
                        <div class="quill-textarea2" style="height: 30vh!important;"><?php echo $demanda['descricao'] ?></div>
                        <textarea style="display: none" id="quill-descricao2" name="descricao"><?php echo $demanda['descricao'] ?></textarea>
                        <input type="hidden" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'comentarios.php'; ?>



<?php include_once ROOT . "/vendor/footer_js.php"; ?>
<script>
    $('.ts-btnDescricaoEditar').click(function() {
        $('.quill-textarea').toggleClass('ts-displayDisable');
        $('.btnSalvarComentario').toggleClass('ts-sumir');
        $('.ql-toolbar').show();
    });

    $('.btnAdicionarComentario').click(function() {
        $('.containerComentario').toggleClass('ts-sumir');
        $('.ts-inputComentario').addClass('ts-sumir');
    });
</script>