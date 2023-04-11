<?php
// Lucas 29032023 - alterado link do botão voltar, para redirecionar para o index.php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../head.php');
include_once('../database/usuario.php');

$usuario = buscaUsuarios($_GET['idUsuario']);

?>

<style>
    #conteudo {
    display: none;
}

#conteudo.mostra {
    display:flex;
}
</style>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">
        <div class="card shadow">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-sm">
                        <h3 class="col">Alterar Usuário</h3>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="../index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 10px">
                <form action="../database/usuario.php?operacao=alterar" method="post">
                    <div class="form-group" style="margin-top:10px">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nomeUsuario" value="<?php echo $usuario['nomeUsuario'] ?>">
                        <input type="text" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" style="display: none">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label>E-mail</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $usuario['email'] ?>">
                    </div>

                    
                  

                    <div class="container" id="conteudo">
                        <div class="row">
                            <div class="col-sm" style="margin-top: 10px">
                                <div class="form-group">
                                    <label>Nova Senha</label>
                                    <input id="txtSenha" type="password" name="password" class="form-control" autocomplete="off" onfocus="this.value='';" placeholder="Senha" required value="<?php echo $usuario['password'] ?>" >
                                </div>
                            </div>
                            <div class="col-sm" style="margin-top: 10px">
                                <div class="form-group">
                                    <label>Repetir Senha</label>
                                    <input type="password" name="senhausuario2" class="form-control" autocomplete="off" onfocus="this.value='';" placeholder="Repetir Senha" value="<?php echo $usuario['password'] ?>" required oninput="validaSenha(this)">
                                    <small>Precisa ser igual a senha digitada.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                   
                    <div class="card-footer bg-transparent" style="text-align:right">
                     

                        <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                    </div>
                </form>
                <button data-classe="classe1" id="btn1" class="btn btn-sm btn-danger mb-3">Alterar Senha</button>
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


        $('#btn1').click(function(){
         $('#conteudo').toggleClass('mostra');
        });

    
    </script>
</body>

</html>