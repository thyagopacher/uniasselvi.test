<?php

include "validaSessao.php";

$produto = new Produto($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $produto->$key = $value;
}

$res = $produto->excluir();

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao excluir produto causado por: ". mysqli_error($conexao->conexao), 'situacao' => true)));
} 

die(json_encode(array('mensagem' => "Produto excluido com sucesso !!!", 'situacao' => true)));
