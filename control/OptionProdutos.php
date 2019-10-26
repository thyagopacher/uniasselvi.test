<?php

include "validaSessao.php";

$produto = new Produto($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $produto->$key = $value;
}

$res = $produto->procurar();
$qtd = $conexao->qtdResultado($res);
if($qtd > 0){
    echo '<option value="">--Selecione--</option>';
    while($produtop = $conexao->resultadoArray($res)){
        echo '<option valor="',$produtop['ValorUnitario'],'" value="',$produtop['CodProduto'],'">',$produtop['NomeProduto'],'</option>';
    }
} else {
    echo '<option value="">--Nada encontrado--</option>';
}