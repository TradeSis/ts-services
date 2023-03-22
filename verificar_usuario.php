<?php
//gabriel 220323 11:19 adicionado idcliente
// helio 26012023 16:16


include_once 'conexao.php';
$usuario = $_POST['usuario'];
$passwordDigitada = $_POST['password'];

$dados = array();
$apiEntrada = array(
	'usuario' => $usuario,
);
$dados = chamaAPI('', '/api/services/usuario/verifica', json_encode($apiEntrada), 'GET');

$password = $dados['password'];
$statusUsuario = $dados['statusUsuario'];
$user = $dados['nomeUsuario'];
$idUsuario = $dados['idUsuario'];
$idCliente = $dados['idCliente'];

$senhaVerificada = md5($passwordDigitada);

//

if (!$user == "") {


	if ($password == $senhaVerificada) {
		session_start();
		$_SESSION['usuario'] = $user;
		$_SESSION['idUsuario'] = $idUsuario;
		$_SESSION['idCliente'] = $idCliente;
		header('Location: index.php');
	}
	else {
		$mensagem = "senha errada!";
		header('Location: login.php?mensagem='. $mensagem);
	}
} else {
	$mensagem = "usuario não cadastrado!";
	//$mensagem = $dados['retorno'];
	/* echo $mensagem; */
	header('Location: login.php?mensagem='. $mensagem);

}