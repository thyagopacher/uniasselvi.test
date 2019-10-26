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
    echo '<table id="tProduto" width="100%" class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th><i class="far fa-money-bill-alt"></i> Valor Unit.</th>';
    echo '<th>Cod. Barras</th>';
    echo '<th>Opções</th>';
    echo '</tr>';
    echo '</thead>';   
    echo '<tbody>';
    while($produtop = $conexao->resultadoArray($res)){
        echo '<tr>';
        echo '<td>',$produtop['NomeProduto'],'</td>';
        echo '<td>',number_format($produtop['ValorUnitario'], 2, ',', '.'),'</td>';
        echo '<td>',$produtop['CodBarras'],'</td>';
        echo '<td>';
        echo '<a href="?CodProduto=',$produtop['CodProduto'],'"><i class="fas fa-pencil-alt"></i></a> ';
        echo '<a href="javascript: excluirProduto(',$produtop['CodProduto'],')"><i class="fas fa-times"></i></a> ';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="alert alert-info">
    <strong>Atenção!</strong> Nada foi encontrado com esta pesquisa, tente alterar os filtros
  </div>';
}