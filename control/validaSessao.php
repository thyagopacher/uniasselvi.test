<?php

header ('Content-type: text/html; charset=UTF-8'); 
session_start();

if (!isset($_SESSION['CodCliente']) || empty($_SESSION['CodCliente'])) {
    die(json_encode(array('mensagem' => 'Isto não é um erro, sua sessão caiu, por favor logue novamente!', 'situacao' => false)));
}
 
function __autoload($class_name) {
    if (file_exists('../model/' . $class_name . '.php')) {
        include '../model/' . $class_name . '.php';
    }
}
 
$conexao = new Conexao();
