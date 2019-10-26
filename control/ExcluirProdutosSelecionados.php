<?php

include "validaSessao.php";

foreach ($_POST['CodProduto'] as $key => $CodProduto) {
    $produto = new Produto($conexao);
    $produto->CodProduto = $CodProduto;
    $res = $produto->excluir();

    if ($res == FALSE) {
        die(json_encode(array('mensagem' => "Erro ao excluir produto causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
    }     
}


die(json_encode(array('mensagem' => "Produto excluido com sucesso !!!", 'situacao' => true)));
