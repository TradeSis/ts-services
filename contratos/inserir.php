<?php
// Lucas 20022023 adicionado o campo de Valor Contrato, linhas: 91 até 94;
// Lucas 10022023 Melhorado estrutura do script
// Lucas 01022023 - Acrescentado campos no form dataPrevisao e dataEntrega, e ajustado layout das colunas do form
// Lucas 01022023 - Retirado placeholder="Titulo do Contrato", linha 40;
// Lucas 01022023 - Ajustado label do form: idCliente, idContratoStatus, Titulo Contrato para Cliente, Status e Titulo;
// Lucas 01022023 - Removido o campo dataFechamento;
// Lucas 01022023 18:22


include '../head.php';
include '../database/contratoStatus.php';
include '../database/clientes.php';

$contratoStatusTodos = buscaContratoStatus();
$clientes = buscaClientes();

?>

<body class="bg-transparent">

    <div class="container text-center card shadow" style="margin-top: 10px;">
        <div class="row">
                <div class="col card-header border-1">
                    <div class="row">
                        <div class="col-sm">
                            <h3 class="col">Inserir Contrato</h3>
                        </div>

                        <div class="col-sm" style="text-align:right">
                            <a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                        </div>
                    </div>
                </div>
        </div>

        <form action="../database/contratos.php?operacao=inserir" method="post" style="margin-top: 20px; padding: 10px; text-align: left">
            <div class="row">
                <label>Titulo</label>
                    <input type="text" class="form-control" name="tituloContrato" required>
                <label>Descrição</label>
                    <textarea class="form-control" name="descricao" autocomplete="off"></textarea>
            </div>

            <div class="row">
                <div class="col">
                    <label>Status</label>
                        <select class="form-control" name="idContratoStatus">
                            <?php
                                foreach ($contratoStatusTodos as $contratoStatus) {
                            ?>
                            <option value="<?php echo $contratoStatus['idContratoStatus'] ?>"><?php echo $contratoStatus['nomeContratoStatus']  ?></option>
                            <?php  } ?>
                        </select>
                </div>

                <div class="col">
                    <label>Previsão</label>
                        <input type="datetime-local" class="form-control" name="dataPrevisao">
                </div>

                <div class="col">
                    <label>Entrega</label>
                        <input type="datetime-local" class="form-control" name="dataEntrega">
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <label>Cliente</label>
                        <select class="form-control" name="idCliente">
                             <?php
                                foreach ($clientes as $cliente) { // ABRE o 
                            ?>
                            <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                            <?php  } ?> <!--FECHA while-->
                        </select>
                </div>

                <div class="col">
                    <label>Horas</label>
                        <input type="number" class="form-control" name="horas" placeholder="horas" autocomplete="off">

                </div>

                <div class="col">
                    <label>Valor Hora</label>
                        <input type="number" class="form-control" name="valorHora" placeholder="valor Hora" autocomplete="off">
                </div>
                
                <div class="col">
                    <label>Valor Contrato</label>
                        <input type="number" class="form-control" name="valorContrato" placeholder="valor Contrato" autocomplete="off">
                </div>

                <div class="col-12" style="text-align: right; padding-top: 20px">
                    <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                </div>
            </div>

        </form>
                
    </div><!-- container -->

</body>
</html>