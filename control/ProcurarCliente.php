<?php

include "validaSessao.php";

$cliente = new Cliente($conexao);
$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $cliente->$key = $value;
}

$res = $cliente->procurar();
$qtd = $conexao->qtdResultado($res);
if($qtd > 0){
    echo '<table id="tCliente" width="100%" class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th>CPF</th>';
    echo '<th>Email</th>';
    echo '<th>Opções</th>';
    echo '</tr>';
    echo '</thead>';   
    echo '<tbody>';
    while($clientep = $conexao->resultadoArray($res)){
        echo '<tr>';
        echo '<td>',$clientep['NomeCliente'],'</td>';
        echo '<td>',$clientep['CPF'],'</td>';
        echo '<td>',$clientep['NomeCliente'],'</td>';
        echo '<td>';
        echo '<a href="?CodCliente=',$clientep['CodCliente'],'"><i class="fas fa-pencil-alt"></i></a> ';
        echo '<a href="javascript: excluirCliente(',$clientep['CodCliente'],')"><i class="fas fa-times"></i></a> ';
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