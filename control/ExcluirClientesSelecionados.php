<?php

include "validaSessao.php";

foreach ($_POST['CodCliente'] as $key => $CodCliente) {
    $cliente = new Cliente($conexao);
    $cliente->CodCliente = $CodCliente;
    $res = $cliente->excluir();

    if ($res == FALSE) {
        die(json_encode(array('mensagem' => "Erro ao excluir cliente causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
    }     
}


die(json_encode(array('mensagem' => "Cliente excluido com sucesso !!!", 'situacao' => true)));
