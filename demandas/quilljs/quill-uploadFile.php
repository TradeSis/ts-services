<?php

//LOG
$arquivo = fopen("C:/TRADESIS/tmp/" . "upload" . date("dmY") . ".log", "a");
fwrite($arquivo, "\n\nFILES->" . json_encode($_FILES) . "\n");
fwrite($arquivo, "POST->" . json_encode($_POST) . "\n");


$destino = $_SERVER['DOCUMENT_ROOT'].$_POST['endereco'].$_FILES['arquivo']["name"];

//LOG
fwrite($arquivo, "DESTINO->" . $destino . "\n");


move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino);
