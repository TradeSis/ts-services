<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/tipostatus.php');
$tiposstatus = buscaTipoStatus();
?>

<body class="bg-transparent">
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
                        <td class="text-center">
                            <?php echo $tipostatus['nomeTipoStatus'] ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#alterarModal"
                                data-idTipoStatus="<?php echo $tipostatus['idTipoStatus'] ?>"><i class='bi bi-pencil-square'></i></button>
                            <a class="btn btn-danger btn-sm"
                                href="tipostatus_excluir.php?idTipoStatus=<?php echo $tipostatus['idTipoStatus'] ?>"
                                role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>


    <div id="alterarModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alterar status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="../database/tipostatus.php?operacao=alterar" method="post">
                        <label>nomeTipoStatus</label>
                        <input type="text" name="nomeTipoStatus" id="nomeTipoStatus" class="form-control" />
                        <br />
                        <label>mudaPosicaoPara</label>
                        <select name="mudaPosicaoPara" id="mudaPosicaoPara" class="form-control">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <br />
                        <label>mudaStatusPara</label>
                        <select name="mudaStatusPara" id="mudaStatusPara" class="form-control">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <input type="hidden" name="idTipoStatus" id="idTipoStatus" />
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i
                                    class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('button[data-target="#alterarModal"]').click(function () {
                var idTipoStatus = $(this).attr("data-idTipoStatus");
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo URLROOT ?>/services/database/tipostatus.php?operacao=buscar',
                    data: {
                        idTipoStatus: idTipoStatus
                    },
                    success: function (data) {
                        $('#nomeTipoStatus').val(data.nomeTipoStatus);
                        $('#mudaPosicaoPara').val(data.mudaPosicaoPara);
                        $('#mudaStatusPara').val(data.mudaStatusPara);
                        $('#idTipoStatus').val(data.idTipoStatus);
                        $('#alterarModal').modal('show');
                    }
                });
            });
        });
    </script>

</body>

</html>