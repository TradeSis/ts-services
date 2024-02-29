// Abrir demanda/visualizar com o click do mouse na tabela
$(document).on('click', '.ts-click', function () {
    window.location.href = '../demandas/visualizar.php?idDemanda=' + $(this).attr('data-idDemanda');
});

// Tabs de contrato/visualizar
var tab;
var tabContent;

window.onload = function () {
    tabContent = document.getElementsByClassName('tabContent');
    tab = document.getElementsByClassName('tab');
    hideTabsContent(1);

    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    if (id === 'demandacontrato') {
        showTabsContent(1);
    }
    if (id === 'contratochecklist') {
        showTabsContent(2);
    }
    if (id === 'notascontrato') {
        showTabsContent(3);
    }
}

document.getElementById('ts-tabs').onclick = function (event) {
    var target = event.target;
    if (target.className == 'tab') {
        for (var i = 0; i < tab.length; i++) {
            if (target == tab[i]) {
                showTabsContent(i);
                break;
            }
        }
    }
}

function hideTabsContent(a) {
    for (var i = a; i < tabContent.length; i++) {
        tabContent[i].classList.remove('show');
        tabContent[i].classList.add("hide");
        tab[i].classList.remove('whiteborder');
    }
}

function showTabsContent(b) {
    if (tabContent[b].classList.contains('hide')) {
        hideTabsContent(0);
        tab[b].classList.add('whiteborder');
        tabContent[b].classList.remove('hide');
        tabContent[b].classList.add('show');
    }
}

// Script de disabilar conteudo da aba quando não estiver ativa
$('.aba1').click(function () {
    $('.aba1_conteudo').show();
    $('.aba1').addClass('whiteborder');
    $('.aba2').removeClass('whiteborder');
    $('.aba3').removeClass('whiteborder');
    $('.aba4').removeClass('whiteborder');
    $('.aba2_conteudo').hide();
    $('.aba3_conteudo').hide();
    $('.aba4_conteudo').hide();
});

$('.aba2').click(function () {
    $('.aba2_conteudo').show();
    $('.aba2').addClass('whiteborder');
    $('.aba1').removeClass('whiteborder');
    $('.aba3').removeClass('whiteborder');
    $('.aba4').removeClass('whiteborder');
    $('.aba1_conteudo').hide();
    $('.aba3_conteudo').hide();
    $('.aba4_conteudo').hide();
});

$('.aba3').click(function () {
    $('.aba3_conteudo').show();
    $('.aba3').addClass('whiteborder');
    $('.aba1').removeClass('whiteborder');
    $('.aba2').removeClass('whiteborder');
    $('.aba4').removeClass('whiteborder');
    $('.aba1_conteudo').hide();
    $('.aba2_conteudo').hide();
    $('.aba4_conteudo').hide();
});
$('.aba4').click(function () {
    $('.aba4_conteudo').show();
    $('.aba4').addClass('whiteborder');
    $('.aba1').removeClass('whiteborder');
    $('.aba2').removeClass('whiteborder');
    $('.aba3').removeClass('whiteborder');
    $('.aba1_conteudo').hide();
    $('.aba2_conteudo').hide();
    $('.aba3_conteudo').hide();
});

// Editor Quill - demanda_inserir
var demandaContrato = new Quill('.quill-demandainserir', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],

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
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['link', 'image'],
            [{
                'color': []
            }, {
                'background': []
            }],

            [{
                'align': []
            }],
        ]
    }
});

demandaContrato.on('text-change', function (delta, oldDelta, source) {
    $('#quill-demandainserir').val(demandaContrato.container.firstChild.innerHTML);
});

var quill = new Quill('.quill-contratoDescricao', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],

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
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['link', 'image'],
            [{
                'color': []
            }, {
                'background': []
            }],

            [{
                'align': []
            }],
        ]
    }
});

quill.on('text-change', function(delta, oldDelta, source) {
    $('#quill-contratoDescricao').val(quill.container.firstChild.innerHTML);
});


$(document).ready(function () {

    $(document).on('click', 'button[data-bs-target="#alterarChecklistModal"]', function () {
        var idChecklist = $(this).attr("data-idChecklist");
        var idContrato = $(this).attr("data-idContrato");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../database/contratochecklist.php?operacao=buscar',
            data: {
                idChecklist: idChecklist,
                idContrato: idContrato
            },
            success: function (data) {
                $('#idChecklist').val(data.idChecklist);
                $('#idContrato').val(data.idContrato);
                $('#descricao').val(data.descricao);
                $('#dataPrevisto').val(data.dataPrevisto);
                $('#alterarChecklistModal').modal('show');
            }
        });
    });

    $(document).on('click', 'button[data-bs-target="#excluirChecklistModal"]', function () {
        var idChecklist = $(this).attr("data-idChecklist");
        var idContrato = $(this).attr("data-idContrato");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../database/contratochecklist.php?operacao=buscar',
            data: {
                idChecklist: idChecklist,
                idContrato: idContrato
            },
            success: function (data) {
                $('#EXCidChecklist').val(data.idChecklist);
                $('#EXCidContrato').val(data.idContrato);
                $('#EXCdescricao').val(data.descricao);
                $('#EXCdataPrevisto').val(data.dataPrevisto);
                $('#excluirChecklistModal').modal('show');
            }
        });
    });

    $(document).on('click', 'button[data-bs-target="#tarefaChecklistModal"]', function () {
        var idChecklist = $(this).attr("data-idChecklist");
        var idContrato = $(this).attr("data-idContrato");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../database/contratochecklist.php?operacao=buscar',
            data: {
                idChecklist: idChecklist,
                idContrato: idContrato
            },
            success: function (data) {
                $('#NEWidChecklist').val(data.idChecklist);
                $('#NEWidContrato').val(data.idContrato);
                $('#NEWdescricao').val(data.descricao);
                $('#NEWdataPrevisto').val(data.dataPrevisto);
                $('#tarefaChecklistModal').modal('show');
            }
        });
    });

    $(document).on('click', '.ts-check', function () {
        var idChecklist = $(this).find("input[type='checkbox']").attr("data-idChecklist");
        var idContrato = $(this).find("input[type='checkbox']").attr("data-idContrato");
        var statusCheck = $(this).find("input[type='checkbox']").is(":checked") ? 1 : 0;
    
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "../database/contratochecklist.php?operacao=alterar",
            data: {
                statusCheck: statusCheck,
                idChecklist: idChecklist,
                idContrato: idContrato
            },
            success: function() { 
                window.location.reload(); 
            }
        });
    });
});
