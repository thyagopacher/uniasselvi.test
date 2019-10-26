<?php
session_start();
if(!isset($_SESSION["CodCliente"]) || $_SESSION["CodCliente"] == NULL || $_SESSION["CodCliente"] == ""){
    die('<script>alert("Sua sessão caiu, por favor se logue novamente !!!");location.href="/sair";</script>');
}
function __autoload($class_name) {
    if (file_exists('../model/' . $class_name . '.php')) {
        include '../model/' . $class_name . '.php';
    }
}
$uri = getenv('REQUEST_URI');
$pagina = str_replace('/', '', $uri);