<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Produto {

    public $CodProduto;
    public $NomeProduto;
    public $ValorUnitario;
    public $CodBarras;
    private $conexao;

    public function __construct($conn) {
        $this->conexao = $conn;  
    }

    public function __destruct() {
        unset($this->conexao);
    }

    public function inserir() {
        return $this->conexao->inserir("produto", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("produto", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("produto", $this);
    }

    public function procurarCodigo($codigo = NULL) {
        if($codigo != NULL){
            $this->CodProduto = $codigo;
        }
        return $this->conexao->procurarCodigo('produto', $this);
    }

    public function procurar(){
        $and = '';
        if(isset($this->ValorUnitario) && $this->ValorUnitario != NULL && $this->ValorUnitario != ""){
            $and .= " and produto.ValorUnitario = '". str_replace(',', '.', $this->ValorUnitario)."'";
        }
        if(isset($this->NomeProduto) && $this->NomeProduto != NULL && $this->NomeProduto != ""){
            $and .= " and produto.NomeProduto like '%{$this->NomeProduto}%'";
        }
        if(isset($this->CodBarras) && $this->CodBarras != NULL && $this->CodBarras != ""){
            $and .= " and produto.CodBarras like '%{$this->CodBarras}%'";
        }
        $sql = "select * from produto where 1 = 1 ${and} order by produto.NomeProduto";
        return $this->conexao->comando($sql);
    }
}
