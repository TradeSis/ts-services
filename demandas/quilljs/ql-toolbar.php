<?php
// QUILLJS TOOBAR
?>
<style>
    .bi-paperclip{
        color: #444444;
        font-size: 17px;
    }
    .bi-paperclip:hover{
        color: #06c;
    }
</style>
    <button class="ql-bold"></button>
    <button class="ql-italic"></button>
    <button class="ql-underline"></button>
    <button class="ql-strike"></button>
    <button class="ql-list" value="ordered" ngbPopover="Ordered list" ></button>
    <button class="ql-list" value="bullet" ngbPopover="Bulleted list" ></button>
    <button class="ql-indent" value="-1" ngbPopover="Indent -1" ></button>
    <button class="ql-indent" value="+1" ngbPopover="Indent +1" ></button>
    <select class="ql-size"></select>
    <select class="ql-color"></select>
    <select class="ql-background"></select>
    <button class="ql-link"></button>
    <button class="ql-image"></button>
    <input type="file" id="custom-button" class="custom-file-upload" name="nomeAnexo" onchange="uploadFile()"
          style=" display:none"    >
    <label for="custom-button">
        <a class="btn p-0 ms-1"><i class="bi bi-paperclip" ></i></a>
    </label>
    <button class="ql-clean"></button>


