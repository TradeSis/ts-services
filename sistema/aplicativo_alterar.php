<?php
//Lucas 04042023 criado

include_once('../head.php');
include_once('../database/aplicativo.php');



$aplicativo = buscaAplicativos($_GET['idAplicativo']);
//echo json_encode($aplicativo);
?>

<link rel="stylesheet" href="../css/aplicativo_alterar.css">

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Alterar Aplicativo</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="aplicativo.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/aplicativo.php?operacao=alterar" method="post">
                    <div class="form-group" style="margin-top:10px">

                        <label>Nome Aplicativo</label>
                        <input type="text" class="form-control" name="nomeAplicativo" value="<?php echo $aplicativo['nomeAplicativo'] ?>">
                        <input type="text" class="form-control" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?> "style="display:none">

                        
                        <label>Imagem</label>

                        <label class="picture" for="imgAplicativo" tabIndex="0">
                            <span class="picture__image"></span>
                        </label>

                        <input type="file" name="imgAplicativo" id="imgAplicativo" value="<?php echo $aplicativo['imgAplicativo'] ?>"> 


                        <!-- <label>Imagem atual</label>
                        <img height="50" src="<?php echo $aplicativo['pathImg'];?>" alt=""> -->
                        

                        
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Alterar</button>
                    </div>
                </form>
            </div>
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