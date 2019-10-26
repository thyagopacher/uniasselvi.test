<?php

include "./validaSessao.php";
$pedido  = new Pedido($conexao);

$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $pedido->$key = $value;
}

if(!isset($pedido->CodCliente) || $pedido->CodCliente == NULL || $pedido->CodCliente == ""){
    die(json_encode(array('mensagem' => "Por favor preencher com cliente relacionado ao pedido !", 'situacao' => false)));
}

if(isset($pedido->NumPedido) && $pedido->NumPedido != NULL && $pedido->NumPedido != ""){
    $res = $pedido->atualizar();
}else{
    $res = $pedido->inserir();
    $pedido->CodPedido = mysqli_insert_id($conexao->conexao);
}

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao salvar pedido causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
} 

foreach ($_POST['CodProduto'] as $key => $value) {
    $jaTinha = $conexao->comandoArray("select CodItem from itempedido where CodPedido = {$pedido->NumPedido} and CodProduto = {$value}");
    $item = new ItemPedido($conexao);
    $item->CodProduto = $value;
    $item->Quantidade = $_POST['Quantidade'][$key];
    $item->CodPedido = $pedido->NumPedido;
    if(isset($jaTinha['CodItem']) && $jaTinha['CodItem'] != NULL && $jaTinha['CodItem'] != ""){
        $item->CodItem = $jaTinha['CodItem'];
        $resInserirItem = $item->atualizar();
    }else{
        $resInserirItem = $item->inserir();
    }
    if($resInserirItem == false){
        die(json_encode(array('mensagem' => "Erro ao salvar item de pedido causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
    }
}

die(json_encode(array('mensagem' => "Pedido salvo com sucesso !!!", 'situacao' => true)));
