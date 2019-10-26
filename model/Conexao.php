<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set('America/Fortaleza');

class Conexao {

    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = '';
    private $banco = 'uniasselvi';
    public $resultado;
    public $conexao;

    function __construct() {
        $this->conectar();
    }

    function __destruct() {
        if (isset($this->resultado) && $this->resultado != NULL) {
            unset($this->resultado);
        }
        if ($this->conexao != FALSE) {
            mysqli_close($this->conexao);
        }
        unset($this->conexao);
    }

    public function conectar() {
        $this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->banco);
        if (!$this->conexao) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        mysqli_set_charset($this->conexao, 'utf8');
    }

    /*
     * retorna mysql_query 
     * @return result
     */

    public function comando($query) {
        if ($query != '') {
            $this->resultado = mysqli_query($this->conexao, $query);
            return $this->resultado;
        }
    }

    /**
     * @assert ('select 1') == true
     */
    public function comandoArray($query) {
        if ($query != "") {
            return mysqli_fetch_array(mysqli_query($this->conexao, $query, MYSQLI_USE_RESULT), MYSQLI_ASSOC);
        }
        return null;
    }

    /*     * retorna a quantidade de resultados da consulta */

    public function qtdResultado($resultado) {
        return mysqli_num_rows($resultado);
    }

    public function resultadoArray($resultado = null) {
        if ($resultado != NULL) {
            $this->resultado = $resultado;
        }
        return mysqli_fetch_array($this->resultado, MYSQLI_ASSOC);
    }

    /**
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com>
     * @param string $tabela 
     * @param array $objeto 
     * @return boolean true para sucesso
     */
    public function inserir($tabela, $objeto) {
        $valores = $campos = '';
        $res = $this->comando('DESC ' . $tabela);
        if ($this->qtdResultado($res) > 0) {
            while ($campo = $this->resultadoArray($res)) {
                $campoNome = $campo['Field'];
                $campoChave = $campo['Key'];
                if (($campoChave != 'PRI' || $campoNome == "codempresa") && isset($objeto->$campoNome) && $objeto->$campoNome != NULL && $objeto->$campoNome != '') {
                    if (is_string($objeto->$campoNome)) {
                        $objeto->$campoNome = addslashes($objeto->$campoNome);
                    }
                    $campos .= "{$campoNome},";
                    $valores .= $this->montaCampos($campo['Type'], $objeto->$campoNome, $campoNome);
                }
            }
        }

        $sql = 'insert into ' . $tabela . '(' . substr($campos, 0, strlen(trim($campos)) - 1) . ') values(' . substr($valores, 0, strlen(trim($valores)) - 1) . ')';
        return mysqli_real_query($this->conexao, $sql);
    }

    public function atualizar($tabela, $objeto) {
        $setar = $where = '';
        $chavePrimaria = 0;
        $res = $this->comando('DESC ' . $tabela);
        if ($this->qtdResultado($res) > 0) {
            while ($campo = $this->resultadoArray($res)) {
                $campoNome = $campo['Field'];
                $campoChave = $campo['Key'];
                $objeto->$campoNome = addslashes($objeto->$campoNome);
                if ($campoChave != 'PRI' && isset($objeto->$campoNome) && $objeto->$campoNome != NULL && $objeto->$campoNome != '') {
                    $setar .= $this->montaCampos($campo['Type'], $objeto->$campoNome, $campoNome, true);
                } elseif ($campoChave === 'PRI') {
                    $chavePrimaria = $objeto->$campoNome;
                    $where .= $campoNome . ' = "' . $chavePrimaria . '"';
                }
            }
        }

        $sql = 'update ' . $tabela . ' set ' . substr($setar, 0, strlen(trim($setar)) - 1) . ' where ' . $where;
        return mysqli_real_query($this->conexao, $sql);
    }

    public function excluir($tabela, $objeto) {
        $where = '';
        $res = $this->comando('DESC ' . $tabela);
        $chavePrimaria = 0;
        if ($this->qtdResultado($res) > 0) {
            while ($campo = $this->resultadoArray($res)) {
                $campoNome = $campo['Field'];
                $campoChave = $campo['Key'];
                if ($campo['Key'] == 'PRI') {
                    $chavePrimaria = $objeto->$campoNome;
                    $where .= $campoNome . '= "' . $objeto->$campoNome . '"';
                    break;
                }
            }
        }

        $sql = 'delete from ' . $tabela . ' where ' . $where;
        return mysqli_real_query($this->conexao, $sql);
    }

    public function montaCampos($tipo, $valor, $nome, $ehAtualizar = false) {
        $valorDefinido = '"' . $valor . '"';
        if ($tipo === 'date' && $valor != NULL && $valor != "" && strpos($valor, '/')) {
            $valorDefinido = '"' . implode('-', array_reverse(explode('/', $valor))) . '"';
        } elseif ($tipo === 'double' && strpos($valor, ',')) {
            $valorDefinido = '"' . str_replace(',', '.', $valor) . '"';
        } elseif ($tipo == "int(11)") {
            $valorDefinido = (int) $valor;
        } 
        if ($ehAtualizar) {
            $valorDefinido = $nome . ' = ' . $valorDefinido;
        }
        return $valorDefinido . ',';
    }

    public function procurarCodigo($tabela, $objeto) {
        $where = '';
        $res = $this->comando('DESC ' . $tabela);
        $qtdTabela = $this->qtdResultado($res);
        if ($qtdTabela > 0) {
            while ($campo = $this->resultadoArray($res)) {
                $campoNome = $campo['Field'];
                $campoChave = $campo['Key'];
                if ($campoChave === 'PRI') {
                    $where .= $campoNome . '= "' . $objeto->$campoNome . '"';
                    break;
                }
            }
        }

        $sql = 'select * from ' . $tabela . ' where ' . $where;
        return $this->comandoArray($sql);
    }

}
