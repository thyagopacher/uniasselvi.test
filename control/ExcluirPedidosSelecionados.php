<?php

include "validaSessao.php";

foreach ($_POST['NumPedido'] as $key => $NumPedido) {
    $pedido = new Pedido($conexao);
    $pedido->NumPedido = $NumPedido;
    $res = $pedido->excluir();

    if ($res == FALSE) {
        die(json_encode(array('mensagem' => "Erro ao excluir pedido causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
    }     
}


die(json_encode(array('mensagem' => "Pedido excluido com sucesso !!!", 'situacao' => true)));
