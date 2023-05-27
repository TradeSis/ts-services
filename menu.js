$('.secao1').click(function(){ 
    $('.menuLateral ul .itensSecao1').toggleClass('mostra');
    $('.menuLateral ul .seta1').toggleClass('gira'); 
});

$('.secao2').click(function(){
    $('.menuLateral ul .itensSecao2').toggleClass('mostra');
    $('.menuLateral ul .seta2').toggleClass('gira');
});

$('.btnAbre').click(function(){
    $('.menuLateral').toggleClass('mostra');
    $('.diviFrame').toggleClass('mostra');
    $('.menusecundario').removeClass('mostra');
});

$('.btnCadastros').click(function(){
    
    $('.menusecundario').toggleClass('mostra');
    $('.diviFrame').toggleClass('mostra');
    
});



