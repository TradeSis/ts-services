async function uploadFile() {

    let endereco = '/tmp/';
    let formData = new FormData();
    var custombutton = document.getElementById("custom-button");
    var arquivo = custombutton.files[0]["name"];

    formData.append("arquivo", custombutton.files[0]);
    formData.append("endereco", endereco);

    destino = endereco + arquivo;

    await fetch('quilljs/quill-uploadFile.php', {
        method: "POST",
        body: formData
    });


    const range = this.quill.getSelection(true)
    
    this.quill.insertText(range.index, arquivo, 'user');
    this.quill.setSelection(range.index, arquivo.length);
    this.quill.theme.tooltip.edit('link', destino);
    this.quill.theme.tooltip.save();

    this.quill.setSelection(range.index + destino.length);

}



