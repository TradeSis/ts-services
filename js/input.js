
    $(document).ready(function() {
        /* $('#Listar').load("cadastros/marcas/listar.php"); */

        $('.form-control').on('focus blur',
            function(e) {
                $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
            }
        ).trigger('blur');
        $('.select').on('change blur',
            function(e) {
                $(this).parents('.form-group-select').toggleClass('focused', (e.type === 'focus' || this.value !== ''));
            }
        ).trigger('blur');

    });

