<?php

include "validaSessao.php";

$Pedido = new Pedido($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $Pedido->$key = $value;
}

$res = $Pedido->excluir();

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao excluir pedido causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
} 

die(json_encode(array('mensagem' => "Pedido excluido com sucesso !!!", 'situacao' => true)));
