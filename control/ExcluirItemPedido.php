<?php

include "validaSessao.php";

$item = new ItemPedido($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $item->$key = $value;
}

$res = $item->excluir();

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao excluir item pedido causado por: ". mysqli_error($conexao->conexao), 'situacao' => true)));
} 

die(json_encode(array('mensagem' => "Item Pedido excluido com sucesso !!!", 'situacao' => true)));
