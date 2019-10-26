<?php

session_start();
header ('Content-type: text/html; charset=UTF-8'); 
include '../model/Conexao.php';
include '../model/Cliente.php';
 
$conexao = new Conexao();
$cliente = new Cliente($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $cliente->$key = $value;
}

$resLogin = $cliente->login();

if(!isset($resLogin["CodCliente"]) || $resLogin["CodCliente"] == NULL || $resLogin["CodCliente"] == ""){
    die(json_encode(array('mensagem' => 'Por favor reveja seu e-mail e senhas você digitou algo incorretamente !!!', 'situacao' => false)));
}

$_SESSION["CodCliente"] = $resLogin["CodCliente"];
die(json_encode(array('mensagem' => 'Login feito com sucesso !!!', 'situacao' => true)));