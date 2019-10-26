<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Pedido {

    public $NumPedido;
    public $DtPedido;
    public $CodCliente;
    public $NomeCliente;
    public $CPF;
    public $PctDesconto;
    private $conexao;

    public function __construct($conn) {
        $this->conexao = $conn;
    }

    public function __destruct() {
        unset($this->conexao);
    }

    public function inserir() {
        return $this->conexao->inserir("pedido", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("pedido", $this);
    }

    public function excluir() {
        $sql = "delete from itempedido where CodPedido = " . $this->NumPedido;
        $resExcluirItem = $this->conexao->comando($sql);
        if($resExcluirItem != false) {
            return $this->conexao->excluir("pedido", $this);
        }else{
            return $resExcluirItem;
        }
    }

    public function procurarCodigo($codigo = NULL) {
        if($codigo != NULL){
            $this->NumPedido = $codigo;
        }
        return $this->conexao->procurarCodigo('pedido', $this);
    }

    public function procurar() {
        $and = '';
        if (isset($this->NumPedido) && $this->NumPedido != NULL && $this->NumPedido != "") {
            $and .= " and pedido.NumPedido = '{$this->NumPedido}'";
        }
        if (isset($this->data1) && $this->data1 != NULL && $this->data1 != "") {
            $and .= " and pedido.data1 >= '{$this->data1}'";
        }
        if (isset($this->data2) && $this->data2 != NULL && $this->data2 != "") {
            $and .= " and pedido.data2 <= '{$this->data2}'";
        }
        if (isset($this->CodCliente) && $this->CodCliente != NULL && $this->CodCliente != "") {
            $and .= " and pedido.CodCliente = '{$this->CodCliente}'";
        }
        if (isset($this->NomeCliente) && $this->NomeCliente != NULL && $this->NomeCliente != "") {
            $and .= " and cliente.NomeCliente like '%{$this->NomeCliente}%'";
        }
        if (isset($this->CPF) && $this->CPF != NULL && $this->CPF != "") {
            $and .= " and cliente.CPF like '%{$this->CPF}%'";
        }
        $sql = "select pedido.NumPedido, pedido.DtPedido, pedido.CodCliente, cliente.NomeCliente,
            (select count(1) from itempedido where itempedido.CodPedido = pedido.NumPedido) as TotalItens,
            (
                select sum(produto.ValorUnitario * item.Quantidade) 
                from itempedido as item
                inner join produto on produto.CodProduto = item.CodProduto
                where item.CodPedido = pedido.NumPedido
            ) as ValorTotal, pedido.PctDesconto
        from pedido 
        inner join cliente on cliente.CodCliente = pedido.CodCliente
        where 1 = 1 ${and} order by pedido.NumPedido";
        return $this->conexao->comando($sql);
    }

}
