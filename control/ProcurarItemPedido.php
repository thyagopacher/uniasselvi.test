<?php

include "validaSessao.php";

$item = new ItemPedido($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $item->$key = $value;
}

$res = $item->procurar();
$qtd = $conexao->qtdResultado($res);
if($qtd > 0){
    echo '<table id="tItemPedido" width="100%" class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Num. Pedido</th>';
    echo '<th>Produto</th>';
    echo '<th>Quantidade</th>';
    echo '<th>Opções</th>';
    echo '</tr>';
    echo '</thead>';   
    echo '<tbody>';
    while($pedidop = $conexao->resultadoArray($res)){
        echo '<tr>';
        echo '<td>',$pedidop['NumPedido'],'</td>';
        echo '<td>',$pedidop['NomeProduto'],'</td>';
        echo '<td>',$pedidop['Quantidade'],'</td>';
        echo '<td>';
        echo '<a href="javascript: excluirItemPedido(',$pedidop['CodItem'],', ',$pedidop['NumPedido'],')"><i class="fas fa-times"></i></a> ';
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