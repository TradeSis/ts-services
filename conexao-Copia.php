<?php
// helio 01022023 criado funcao defineConexao API e MySQl com aprametros locais
// helio 01022023 altereado para include_once
// helio 31012023 - include database/api
// helio 26012023 16:16

function defineConexaoApi () {
  //$apiIP = 'https://dev.tsplaces.com.br';
	$apiIP = 'http://localhost/ts';
    return $apiIP;
} 

function defineConexaoMysql () {

    $host = 'localhost';
    $base = 'tsplaces_tsservices';
    $usuario = 'root';
    $senhabd = '';

    return        array(   "host" => $host, 
                           "base" => $base,
                        "usuario" => $usuario, 
                        "senhadb" => $senhabd
                            );

}
function defineEmail () {

  return        array(  "Host"      => 'smtp.hostinger.com', 
                        "Port"      => 465, 
                        "Username"  => 'tradesis@tradesis.com.br',
                        "Password"  => '',
                        "from"      => 'tradesis@tradesis.com.br',
                        "fromNome"  => 'tradesis'
                          );

}

function defineSenderWhatsapp () {
  return        array(  'api_key' => '*47C1C75E4E85AA2209D0C4540C4BFDD3D05E0143', 
                        'sender' => '5551992234364'
                          );

}


function defineROOT () {

  $ROOT = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
  $ROOTex = explode("/", $ROOT);
  $ROOT = $_SERVER['DOCUMENT_ROOT']."/".$ROOTex[1];
  return $ROOT;

}


include_once('database/mysql.php');
include_once('database/api.php');




?>
