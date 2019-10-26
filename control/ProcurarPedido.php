<?php

include "validaSessao.php";

$pedido = new Pedido($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $pedido->$key = $value;
}

$res = $pedido->procurar();
$qtd = $conexao->qtdResultado($res);
if ($qtd > 0) {
    echo '<table id="tPedido" width="100%" class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><i class="far fa-calendar-alt"></i> Dt. Pedido</th>';
    echo '<th>Num. Pedido</th>';
    echo '<th>Cliente</th>';
    echo '<th>Qtd. Itens</th>';
    echo '<th>Opções</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($pedidop = $conexao->resultadoArray($res)) {
        echo '<tr>';
        echo '<td data-order="', $pedidop['DtPedido'], '">', date("d/m/Y H:i", strtotime($pedidop['DtPedido'])), '</td>';
        echo '<td>', $pedidop['NumPedido'], '</td>';
        echo '<td><a target="_blank" title="Clique para visualizar detalhes do cliente" href="/cliente?CodCliente=', $pedidop['CodCliente'], '">', $pedidop['NomeCliente'], '</a></td>';
        echo '<td>', $pedidop['TotalItens'], '</td>';
        echo '<td>';
        echo '<a href="?NumPedido=', $pedidop['NumPedido'], '"><i class="fas fa-pencil-alt"></i></a> ';
        echo '<a href="javascript: excluirPedido(', $pedidop['NumPedido'], ')"><i class="fas fa-times"></i></a> ';
        echo '<a href="javascript: listarItensPedido(', $pedidop['NumPedido'], ')"><i class="far fa-sticky-note"></i></a> ';
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