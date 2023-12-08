<form action="../database/demanda.php?operacao=descricao" method="post">
    <div class="col-md-12">
        <div class="container-fluid p-0 ts-containerDescricaoDemanda">
            <div class="row">
                <div class="col">
                <span class="tituloEditor">Descrição</span>
                </div>
                <div class="col text-end">
                <a class="ts-btnDescricaoEditar"><i class="bi bi-pen"></i>&#32;Editar</a>
                </div>
            </div>
          
            <div class="quill-textarea ts-displayDisable" style="height: 30vh!important;"><?php echo $demanda['descricao'] ?></div>
            <textarea style="display: none" id="quill-descricao" name="descricao"><?php echo $demanda['descricao'] ?></textarea>
            <input type="hidden" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
        </div>
    </div><!--col-md-6-->
    <div class="col text-end">
        <button type="submit" class="btn btn-success mt-1 btnSalvarComentario ts-sumir">Salvar</button>
    </div>
</form>

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