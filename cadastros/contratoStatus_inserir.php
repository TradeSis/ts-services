<?php
// helio 26012023 16:16

include_once('../head.php');
?>

<body>

    <div class="container-fluid" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <h3 class="col">Inserir Status</h3>
                    <div style="text-align:right">
                       
                        <a href="contratoStatus.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                
                <form action="../database/contratoStatus.php?operacao=inserir" method="post" >                    
                    <label>Nome Status</label>
                    <div class="form-group" style="margin-top:10px">
                        <input type="text" name="nomeContratoStatus" class="form-control" placeholder="Status do contrato" autocomplete="off">
                    </div>
                    <div class="card-footer py-2">
                        <div style="text-align:right">
                            <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>