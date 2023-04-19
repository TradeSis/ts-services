<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/aplicativo.php');



$aplicativo = buscaAplicativos($_GET['idAplicativo']);
//echo json_encode($aplicativo);
?>

<body class="bg-transparent">

<div class="container" style="margin-top:10px">

<div class="col-sm mt-4" style="text-align:right">
    <a href="aplicativo.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
</div>
<div class="col-sm">
    <spam class="col titulo">Alterar Aplicativo</spam>
</div>

<div class="container" style="margin-top: 30px">

    <form action="../database/aplicativo.php?operacao=alterar" method="post" enctype="multipart/form-data">

        <div class="col-md-12 form-group">

            <label class='control-label' for='inputNormal'></label>
            <input type="text" name="nomeAplicativo" class="form-control" value="<?php echo $aplicativo['nomeAplicativo'] ?>">
            <input type="text" class="form-control" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?> "style="display:none">

            <label class="labelForm mt-4">Imagem</label>
            <label class="picture" for="imgAplicativo" tabIndex="0">
                <span class="picture__image"></span>
            </label>

            <input type="file" name="imgAplicativo" id="imgAplicativo" value="<?php echo $aplicativo['imgAplicativo'] ?>">

        </div>
        <div style="text-align:right; margin-top: 30px">

            <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
        </div>
    </form>
</div>

</div>

    <script>

//Carregar a imagem na tela
const inputFile = document.querySelector("#imgAplicativo");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "Carregar imagem";
pictureImage.innerHTML = "<img src='<?php echo $aplicativo['pathImg'];?>'>";

inputFile.addEventListener("change", function(e) {
    const inputTarget = e.target;
    const file = inputTarget.files[0];

    if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function(e) {
            const readerTarget = e.target;

            const img = document.createElement("img");
            img.src = readerTarget.result;
            img.classList.add("picture__img");

            pictureImage.innerHTML = "";
            pictureImage.appendChild(img);
        });

        reader.readAsDataURL(file);
    } else {
        pictureImage.innerHTML = "";
    }
});
</script>

</body>

</html>