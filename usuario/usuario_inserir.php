<?php
// helio 01022023 criado option null para empresa
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../head.php');
include_once '../database/clientes.php';

$clientes = buscaClientes();

?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Cadastro de Usuário</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="usuario.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/usuario.php?operacao=inserir" method="post">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Nome do Usuário</label>
                                <input type="text" name="nomeUsuario" class="form-control" required autocomplete="off" placeholder="Nome do Cliente">
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="email" class="form-control" required autocomplete="off" placeholder="E-mail Cliente">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm" style="margin-top: 10px">
                            <div class="form-group">
                                <label>Senha do Usuário</label>
                                <input id="txtSenha" type="password" name="password" class="form-control" required autocomplete="off" placeholder="Senha">
                            </div>
                        </div>
                        <div class="col-sm" style="margin-top: 10px">
                            <div class="form-group">
                                <label>Repetir Senha</label>
                                <input type="password" name="senhausuario2" class="form-control" required autocomplete="off" placeholder="Repetir Senha" oninput="validaSenha(this)">
                                <small>Precisa ser igual a senha digitada acima.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Empresa / Cliente</label>
                                <select class="form-control" name="idCliente">
                                <option value=null></option>
                                    <?php
                                    foreach ($clientes as $cliente) {
                                    ?>
                                        <option value="<?php echo $idcliente ?>"><?php echo $cliente['nomeCliente'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent" style="text-align:right">
                        <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <script>
        function validaSenha(input) {
            if (input.value != document.getElementById('txtSenha').value) {
                input.setCustomValidity('Repita a senha corretamente');
            } else {
                input.setCustomValidity('');
            }
        }
    </script>


</body>

</html>