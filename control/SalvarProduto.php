<?php

include "./validaSessao.php";
$produto  = new Produto($conexao);

$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $produto->$key = $value;
}

if(!isset($produto->NomeProduto) || $produto->NomeProduto == NULL || $produto->NomeProduto == ""){
    die(json_encode(array('mensagem' => "Por favor preencher nome do produto é obrigatório !", 'situacao' => false)));
}
if(!isset($produto->ValorUnitario) || $produto->ValorUnitario == NULL || $produto->ValorUnitario == ""){
    die(json_encode(array('mensagem' => "Por favor preencher valor do produto é obrigatório !", 'situacao' => false)));
}
if(!isset($produto->CodBarras) || $produto->CodBarras == NULL || $produto->CodBarras == ""){
    die(json_encode(array('mensagem' => "Por favor preencher código de barras do produto é obrigatório !", 'situacao' => false)));
}

if(isset($produto->CodProduto) && $produto->CodProduto != NULL && $produto->CodProduto != ""){
    $res = $produto->atualizar();
}else{
    $res = $produto->inserir();
}

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao salvar produto causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
} 

die(json_encode(array('mensagem' => "Produto salvo com sucesso !!!", 'situacao' => true)));
