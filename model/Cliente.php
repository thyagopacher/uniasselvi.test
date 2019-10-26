<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Cliente {

    public $CodCliente;
    public $NomeCliente;
    public $CPF;
    public $Email;
    public $Senha;
    private $conexao;

    public function __construct($conn) {
        $this->conexao = $conn;  
    }

    public function __destruct() {
        unset($this->conexao);
    }

    public function inserir() {
        return $this->conexao->inserir("cliente", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("cliente", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("cliente", $this);
    }

    public function procurarCodigo($codigo = NULL) {
        if($codigo != NULL){
            $this->CodCliente = $codigo;
        }
        return $this->conexao->procurarCodigo('cliente', $this);
    }

    public function login() {
        $sql = 'select CodCliente   
        from cliente 
        where cliente.Email = "'.addslashes(trim($this->Email)).'" and cliente.Senha = "' . md5(trim($this->Senha)) . '"';
        return $this->conexao->comandoArray($sql);
    }

    public function procurar(){
        $and = '';
        if(isset($this->Email) && $this->Email != NULL && $this->Email != ""){
            $and .= " and cliente.Email like '%{$this->Email}%'";
        }
        if(isset($this->NomeCliente) && $this->NomeCliente != NULL && $this->NomeCliente != ""){
            $and .= " and cliente.NomeCliente like '%{$this->NomeCliente}%'";
        }
        if(isset($this->CPF) && $this->CPF != NULL && $this->CPF != ""){
            $and .= " and cliente.CPF like '{$this->CPF}'";
        }
        $sql = "select * from cliente where 1 = 1 ${and} order by cliente.NomeCliente";
        return $this->conexao->comando($sql);
    }
}
