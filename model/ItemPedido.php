<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class ItemPedido {

    public $CodItem;
    public $CodPedido;
    public $CodProduto;
    public $Quantidade;
    private $conexao;

    public function __construct($conn) {
        $this->conexao = $conn;  
    }

    public function __destruct() {
        unset($this->conexao);
    }

    public function inserir() {
        return $this->conexao->inserir("itempedido", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("itempedido", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("itempedido", $this);
    }

    public function procurarCodigo() {
        return $this->conexao->procurarCodigo('itempedido', $this);
    }

    public function procurar(){
        $and = '';
        if(isset($this->CodItem) && $this->CodItem != NULL && $this->CodItem != ""){
            $and .= " and i.CodItem = '{$this->CodItem}'";
        }
        if(isset($this->Quantidade) && $this->Quantidade != NULL && $this->Quantidade != ""){
            $and .= " and i.Quantidade = '{$this->Quantidade}'";
        }
        if(isset($this->CodPedido) && $this->CodPedido != NULL && $this->CodPedido != ""){
            $and .= " and i.CodPedido = '{$this->CodPedido}'";
        }
        if(isset($this->CodProduto) && $this->CodProduto != NULL && $this->CodProduto != ""){
            $and .= " and i.CodProduto = '{$this->CodProduto}'";
        }
        $sql = "select produto.NomeProduto, i.Quantidade, produto.ValorUnitario,
            (i.Quantidade * produto.ValorUnitario) as total, produto.CodProduto, i.CodPedido as NumPedido,
            i.CodItem
        from itempedido as i
        inner join produto on produto.CodProduto = i.CodProduto
        where 1 = 1 $and order by i.CodItem";
        return $this->conexao->comando($sql);
    }
}
