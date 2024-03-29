<?php

include "./validaSessao.php";
$cliente  = new Cliente($conexao);

$variables = (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $cliente->$key = $value;
}

if(!isset($cliente->NomeCliente) || $cliente->NomeCliente == NULL || $cliente->NomeCliente == ""){
    die(json_encode(array('mensagem' => "Por favor preencher nome do cliente é obrigatório !", 'situacao' => false)));
}
if(!isset($cliente->Email) || $cliente->Email == NULL || $cliente->Email == ""){
    die(json_encode(array('mensagem' => "Por favor preencher e-mail do cliente é obrigatório !", 'situacao' => false)));
}elseif(strlen($cliente->Email) < 3){
    die(json_encode(array('mensagem' => "Por favor rever pois e-mail deve ser maior que 3 digitos !", 'situacao' => false)));
}elseif(strstr($cliente->Email, "@") == false){
    die(json_encode(array('mensagem' => "Por favor rever pois e-mail deve conter obrigatoriamente @ !", 'situacao' => false)));
}else{
    $separaEmail = explode("@", $cliente->Email);
    if(count($separaEmail) != 2 || strlen($separaEmail[0]) < 2 || strlen($separaEmail[1]) < 2){
        die(json_encode(array('mensagem' => "Por favor rever pois e-mail deve conter obrigatoriamente 1 parte antes do @ e outra depois !", 'situacao' => false)));
    }
}
if(!isset($cliente->CPF) || $cliente->CPF == NULL || $cliente->CPF == ""){
    die(json_encode(array('mensagem' => "Por favor preencher CPF do cliente é obrigatório !", 'situacao' => false)));
}

/**criptografia de senha assim evita qualquer um saiba a mesma*/
if(isset($cliente->Senha) && $cliente->Senha != NULL && $cliente->Senha != ""){
    $cliente->Senha = md5($cliente->Senha);
}

if(isset($cliente->CodCliente) && $cliente->CodCliente != NULL && $cliente->CodCliente != ""){
    $res = $cliente->atualizar();
}else{
    $cpfJaUsado = $conexao->comandoArray("select CodCliente from cliente where CPF = '{$cliente->CPF}'");
    if(isset($cpfJaUsado['CodCliente']) && $cpfJaUsado['CodCliente'] != NULL && $cpfJaUsado['CodCliente'] != ""){
        die(json_encode(array('mensagem' => "Por favor rever pois este CPF já foi usado em outro cadastro !!!", 'situacao' => false)));
    }
    $res = $cliente->inserir();
}

if ($res == FALSE) {
    die(json_encode(array('mensagem' => "Erro ao salvar cliente causado por: ". mysqli_error($conexao->conexao), 'situacao' => false)));
} 

die(json_encode(array('mensagem' => "Cliente salvo com sucesso !!!", 'situacao' => true)));
