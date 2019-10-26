<?php

include "validaSessao.php";

$cliente = new Cliente($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $cliente->$key = $value;
}

$res = $cliente->excluir();

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao excluir cliente causado por: ". mysqli_error($conexao->conexao), 'situacao' => true)));
} 

die(json_encode(array('mensagem' => "Cliente excluido com sucesso !!!", 'situacao' => true)));
