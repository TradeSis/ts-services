<?php


include_once('../head.php');
?>

<style>
    .custom-file-upload {
        /* border: 1px solid #ccc; */
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        color: #fff;
    }

    ::-webkit-file-upload-button {
        opacity: 0;

        padding: 0.5em;
    }

    .iconeImg {
        font-size: 50px;
        color: #000;
        border: 1px solid #000;
        border-radius: 25px;
    }

    #imgAplicativo {
  display: none;
}

.picture {
  width: 120px;
  height: 120px;
  background: #ddd;
  display: flex;
  align-items: center;
  text-align: center;
  justify-content: center;
  color: #aaa;
  border: 1px dashed currentcolor;
  border-radius: 100px;
  cursor: pointer;
  font-family: sans-serif;
  transition: color 300ms ease-in-out, background 300ms ease-in-out;
  outline: none;
  overflow: hidden;
}

.picture:hover {
  color: #777;
  background: #ccc;
}

.picture:active {
  border-color: turquoise;
  color: turquoise;
  background: #eee;
}

.picture:focus {
  color: #777;
  background: #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.picture__img {
  max-width: 100%;
}
</style>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Inserir Aplicativo</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="aplicativo.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">

                <form action="../database/aplicativo.php?operacao=inserir" method="post" enctype="multipart/form-data">

                    <div class="form-group" style="margin-top:10px">
                        <label>Aplicativo</label>
                        <input type="text" name="aplicativo" class="form-control" placeholder="Digite o nome do Cliente" autocomplete="off">
                        <label>Nome Aplicativo</label>
                        <input type="text" name="nomeAplicativo" class="form-control" placeholder="Digite o nome do Cliente" autocomplete="off">
                        <label>Imagem</label>
                        <input type="text" name="imgAplicativo" class="form-control" placeholder="Digite o nome do Cliente" autocomplete="off">    
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">

                        <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>