<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/tipoocorrencia.php');
$ocorrencias = buscaTipoOcorrencia();

?>

<body class="bg-transparent">
    <div class="container" style="margin-top:10px">
        <div class="row mt-4">
            <div class="col-sm-8">
                <h2 class="tituloTabela" style="color:#12192C">Tipo Ocorrência</h2>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="tipoocorrencia_inserir.php" role="button" class="btn btn-success"><i class="bi bi-plus-square"></i>&nbsp Novo</a>
            </div>
        </div>
        <div class="card mt-2 text-center" >
            <table class="table">
                <thead style="background-color: #12192C; color:#fff">
                    <tr>
                        <th>Ocorrência</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <?php
                foreach ($ocorrencias as $ocorrencia) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#alterarModal"
                                data-idTipoOcorrencia="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><i class="bi bi-pencil-square"></i></button>
                            <a class="btn btn-danger btn-sm"
                                href="tipoocorrencia_excluir.php?idTipoOcorrencia=<?php echo $ocorrencia['idTipoOcorrencia'] ?>"
                                role="button"><i class="bi bi-trash3"></i></a>
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
                    <h4 class="modal-title">Alterar ocorrencia</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="../database/tipoocorrencia.php?operacao=alterar" method="post">
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                <label class="labelForm">Ocorrência</label>
                                <input type="text" name="nomeTipoOcorrencia" id="nomeTipoOcorrencia"
                                    class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="labelForm">Inicial</label>
                                <select class="form-control" id="ocorrenciaInicial" name="ocorrenciaInicial">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="idTipoOcorrencia" id="idTipoOcorrencia" />
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
                var idTipoOcorrencia = $(this).attr("data-idTipoOcorrencia");
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo URLROOT ?>/services/database/tipoocorrencia.php?operacao=buscar',
                    data: {
                        idTipoOcorrencia: idTipoOcorrencia
                    },
                    success: function (data) {
                        //alert(JSON.stringify(data, null, 2));

                        $('#nomeTipoOcorrencia').val(data.nomeTipoOcorrencia);
                        $('#ocorrenciaInicial').val(data.ocorrenciaInicial);
                        $('#idTipoOcorrencia').val(data.idTipoOcorrencia);
                        $('#alterarModal').modal('show');
                    },
                });
            });
        });
    </script>

</body>

</html>