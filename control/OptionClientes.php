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
    echo '<option value="">--Selecione--</option>';
    while($clientep = $conexao->resultadoArray($res)){
        $selectedOpt = '';
        if($_POST["CodCliente"] == $clientep['CodCliente']){
            $selectedOpt = "selected";
        }
        echo '<option ',$selectedOpt,' value="',$clientep['CodCliente'],'">',$clientep['NomeCliente'],'</option>';
    }
} else {
    echo '<option value="">--Nada encontrado--</option>';
}