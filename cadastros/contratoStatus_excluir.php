<?php
// helio 26012023 16:16

include '../head.php';
include '../database/contratoStatus.php';

$idContratoStatus = $_GET['idContratoStatus'];

$contratoStatus = buscaContratoStatus($idContratoStatus);



?>


<body>

    <div class="container-fluid" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <h3 class="col">Excluir Status</h3>
                    <div style="text-align:right">
                       
                        <a href="contratoStatus.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/contratoStatus.php?operacao=excluir" method="post" >                    
                <div class="form-group" style="margin-top:10px">
                    <label>Nome Status</label>
                    <input type="text" class="form-control" name="nomeContratoStatus" value="<?php echo $contratoStatus['nomeContratoStatus'] ?>">
                    <input type="text" class="form-control" name="idContratoStatus" value="<?php echo $contratoStatus['idContratoStatus'] ?>" style="display: none">
                </div>
                    <div class="card-footer py-2">
                        <div style="text-align:right">
                            <button type="submit" class="btn btn-sm btn-success">Excluir</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>

