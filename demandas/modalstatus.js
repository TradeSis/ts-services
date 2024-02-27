/* DEVOLVER */
var quillDevolver = new Quill('#ql-editorDevolver', {
    modules: {
        toolbar: '#ql-toolbarDevolver'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
});

quillDevolver.on('text-change', function (delta, oldDelta, source) {
    $('#quill-devolver').val(quillDevolver.container.firstChild.innerHTML);
});

async function uploadFileDevolver() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("anexarDevolver");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });

    const range = this.quillDevolver.getSelection(true)

    this.quillDevolver.insertText(range.index, arquivo, 'user');
    this.quillDevolver.setSelection(range.index, arquivo.length);
    this.quillDevolver.theme.tooltip.edit('link', destino);
    this.quillDevolver.theme.tooltip.save();

    this.quillDevolver.setSelection(range.index + destino.length);

}


/* ENCAMINHAR */
var quillEncaminhar = new Quill('#ql-editorEncaminhar', {
    modules: {
        toolbar: '#ql-toolbarEncaminhar'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
});

quillEncaminhar.on('text-change', function (delta, oldDelta, source) {
    $('#quill-encaminhar').val(quillEncaminhar.container.firstChild.innerHTML);
});

async function uploadFileEncaminhar() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("anexarEncaminhar");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });

    const range = this.quillEncaminhar.getSelection(true)

    this.quillEncaminhar.insertText(range.index, arquivo, 'user');
    this.quillEncaminhar.setSelection(range.index, arquivo.length);
    this.quillEncaminhar.theme.tooltip.edit('link', destino);
    this.quillEncaminhar.theme.tooltip.save();

    this.quillEncaminhar.setSelection(range.index + destino.length);

}

/* ENCERRAR */
var quillEncerrar = new Quill('#ql-editorEncerrar', {
    modules: {
        toolbar: '#ql-toolbarEncerrar'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
});

quillEncerrar.on('text-change', function(delta, oldDelta, source) {
    $('#quill-encerrar').val(quillEncerrar.container.firstChild.innerHTML);
});

async function uploadFileEncerrar() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("anexarEncerrar");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });

    const range = this.quillEncerrar.getSelection(true)

    this.quillEncerrar.insertText(range.index, arquivo, 'user');
    this.quillEncerrar.setSelection(range.index, arquivo.length);
    this.quillEncerrar.theme.tooltip.edit('link', destino);
    this.quillEncerrar.theme.tooltip.save();

    this.quillEncerrar.setSelection(range.index + destino.length);

}

/* ENTREGAR */
var quillEntregar = new Quill('#ql-editorEntregar', {
    modules: {
        toolbar: '#ql-toolbarEntregar'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
});

quillEntregar.on('text-change', function(delta, oldDelta, source) {
    $('#quill-entregar').val(quillEntregar.container.firstChild.innerHTML);
});

async function uploadFileEntregar() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("anexarEntregar");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });

    const range = this.quillEntregar.getSelection(true)

    this.quillEntregar.insertText(range.index, arquivo, 'user');
    this.quillEntregar.setSelection(range.index, arquivo.length);
    this.quillEntregar.theme.tooltip.edit('link', destino);
    this.quillEntregar.theme.tooltip.save();

    this.quillEntregar.setSelection(range.index + destino.length);

}

/* REABRIR */
var quillReabrir = new Quill('#ql-editorReabrir', {
    modules: {
        toolbar: '#ql-toolbarReabrir'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
});

quillReabrir.on('text-change', function(delta, oldDelta, source) {
    $('#quill-reabrir').val(quillReabrir.container.firstChild.innerHTML);
});

async function uploadFileReabrir() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("anexarReabrir");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });

    const range = this.quillReabrir.getSelection(true)

    this.quillReabrir.insertText(range.index, arquivo, 'user');
    this.quillReabrir.setSelection(range.index, arquivo.length);
    this.quillReabrir.theme.tooltip.edit('link', destino);
    this.quillReabrir.theme.tooltip.save();

    this.quillReabrir.setSelection(range.index + destino.length);

}

/* RESPONDER */
var quillResponder = new Quill('#ql-editorResponder', {
    modules: {
        toolbar: '#ql-toolbarResponder'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
});

quillResponder.on('text-change', function (delta, oldDelta, source) {
    $('#quill-responder').val(quillResponder.container.firstChild.innerHTML);
});

async function uploadFileResponder() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("anexarResponder");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });

    const range = this.quillResponder.getSelection(true)

    this.quillResponder.insertText(range.index, arquivo, 'user');
    this.quillResponder.setSelection(range.index, arquivo.length);
    this.quillResponder.theme.tooltip.edit('link', destino);
    this.quillResponder.theme.tooltip.save();

    this.quillResponder.setSelection(range.index + destino.length);

}