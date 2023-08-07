<?php
// helio 07082023 - Botao POPUP
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once(__DIR__ . '/../head.php');

include_once(__DIR__ . '/../database/tipostatus.php');

$tiposstatus = buscaTipoStatus(); 
?>

<script>
    // Logica para Visualizar via Modal
    async function popTipoStatus(idTipoStatus){
        
        const dados = await fetch("<?php echo URLROOT ?>/services/database/tipostatus.php?operacao=GET_JSON&idTipoStatus=" + idTipoStatus);
        const resposta = await dados.json();
        const popTipoStatus = new bootstrap.Modal(document.getElementById("popTipoStatus"));
        popTipoStatus.show();
        document.getElementById("idTipoStatus").innerHTML = resposta.idTipoStatus;
        document.getElementById("nomeTipoStatus").innerHTML = resposta.nomeTipoStatus;
        document.getElementById("nomeTipoStatus").value = resposta.nomeTipoStatus;

    }
     
    

</script>

<body class="bg-transparent" >
    <div class="container" style="margin-top:10px">

            <div class="row mt-4">
                <div class="col-sm-8">
                        <p class="tituloTabela">Tipos de Status</p>
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="tipostatus_inserir.php" role="button" class="btn btn-primary">Adicionar Status</a>
                    </div>
          
            </div>

        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($tiposstatus as $tipostatus) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $tipostatus['nomeTipoStatus'] ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="tipostatus_alterar.php?idTipoStatus=<?php echo $tipostatus['idTipoStatus'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="tipostatus_excluir.php?idTipoStatus=<?php echo $tipostatus['idTipoStatus'] ?>" role="button">Excluir</a>
                            
                            <button id="<?php echo $tipostatus['idTipoStatus'] ?>" class='btn btn-outline-warning btn-sm' onclick="popTipoStatus(<?php echo $tipostatus['idTipoStatus'] ?>)">Editar</button>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        
    </div>
    // MODAIS
    <div class="modal fade" id="popTipoStatus" tabindex="-1" aria-labelledby="popTipoStatusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popTipoStatusLabel">Tipos de Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-usuario-form">
                        <span id="msgAlertaErroEdit"></span>

                        <span id="idTipoStatus"></span>

                        <div class="mb-3">
                            <label for="nomeTipoStatus" class="col-form-label">Nome:</label>
                            <input type="text" name="nomeTipoStatus" class="form-control" id="nomeTipoStatus" placeholder="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
