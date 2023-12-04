<style>
    .ts-displayDisable {
        background: #eee;
        pointer-events: none;
        touch-action: none;
    }

    .sumir {
        display: none;
    }
</style>

<form action="../database/demanda.php?operacao=descricao" method="post">
    <div class="col-md-12">
        <div class="container-fluid p-0">
            <div class="col text-end" style="margin-bottom: -15px;">
                <button type="button" class="btn btn-primary  btnEditar">Editar</button>
            </div>
            <div class="col">
                <span class="tituloEditor">Descrição</span>
            </div>
            <div class="quill-textarea ts-displayDisable"><?php echo $demanda['descricao'] ?></div>
            <textarea style="display: none" id="quill-descricao" name="descricao"><?php echo $demanda['descricao'] ?></textarea>
            <input type="hidden" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
        </div>
    </div><!--col-md-6-->
    <div class="col text-end">
        <button type="submit" class="btn btn-success mt-1 btnSalvarComentario sumir">Salvar</button>
    </div>
</form>

<?php include_once 'comentarios.php'; ?>



<?php include_once ROOT . "/vendor/footer_js.php"; ?>
<script>
    $('.btnEditar').click(function() {
        $('.quill-textarea').toggleClass('ts-displayDisable');
        $('.btnSalvarComentario').toggleClass('sumir');

    });

    $('.btnAdicionarComentario').click(function() {
        $('.containerComentario').toggleClass('sumir'); 
        $('.ts-inputComentario').addClass('sumir');
    });
</script>