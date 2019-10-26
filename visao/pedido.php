<?php
include "validaSessao.php";
$conexao = new Conexao();
if (isset($_GET['NumPedido']) && $_GET['NumPedido'] != NULL && $_GET['NumPedido'] != "") {

    $pedido = new Pedido($conexao);
    $pedidop = $pedido->procurarCodigo($_GET['NumPedido']);
} else {
    $pedidop = NULL;
}
$produto = new Produto($conexao);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Pedidos</title>
        <?php include "cssGeral.php"; ?>
        <style>
            .divInputs{
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <datalist id="ListaProduto">
            <?php
            $produtos = array();
            $resProdutos = $produto->procurar();
            $qtdProdutos = $conexao->qtdResultado($resProdutos);
            if ($qtdProdutos > 0) {
                echo '<option value="">--Selecione--</option>';
                while ($produtop = $conexao->resultadoArray($resProdutos)) {
                    $produtos[] = $produtop;
                    echo '<option valor="', $produtop['ValorUnitario'], '" value="', $produtop['CodProduto'], '">', $produtop['NomeProduto'], '</option>';
                }
            }
            ?>
        </datalist>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <?php include "./menuLateral.php"; ?>               
                </div>
                <div class="col-md-10">
                    <div class="container-fluid">
                        <h2>Pedidos</h2>
                        <br>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home">Cadastro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#menu1">Procurar</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="home" class="container-fluid tab-pane active"><br>
                                <h3>Cadastro de Pedidos</h3>
                                <form method="post" id="fpedido" onsubmit="return false;">
                                    <input type="hidden" name="NumPedido" id="NumPedido" value="<?= $pedidop['NumPedido'] ?>">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select name="CodCliente" id="CodCliente" class="form-control">
                                                <option value="">--Carregando--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>% Desconto</label>
                                            <input type="text" name="PctDesconto" id="PctDesconto" class="form-control real" value="<?=$pedidop['PctDesconto']?>"/>
                                        </div>
                                    </div>
                                    
                                    <div id="itensPedidos" class="col-md-12 divInputs">
                                        <?php
                                        if (isset($_GET['NumPedido']) && $_GET['NumPedido'] != NULL && $_GET['NumPedido'] != "") {
                                            $item = new ItemPedido($conexao);
                                            $item->CodPedido = $_GET['NumPedido'];
                                            $resItens = $item->procurar();
                                            $qtdItens = $conexao->qtdResultado($resItens);

                                            if ($qtdItens > 0) {
                                                $linha = 1;
                                                $html = '';
                                                while ($itensp = $conexao->resultadoArray($resItens)) {
                                                    $proxLinha = $linha + 1;
                                                    $html .= "<div class='col-md-12' id='item$linha'>";
                                                    $html .= "<select name='CodProduto[]' id='CodProduto$linha' value='{$itensp['CodProduto']}' class='form-control col-md-5'>";
                                                    foreach ($produtos as $key => $produtop) {
                                                        $selectedOpt = "";
                                                        if ($produtop['CodProduto'] == $itensp['CodProduto']) {
                                                            $selectedOpt = "selected";
                                                        }
                                                        $html .= '<option ' . $selectedOpt . ' valor="' . $produtop['ValorUnitario'] . '" value="' . $produtop['CodProduto'] . '">' . $produtop['NomeProduto'] . '</option>';
                                                    }
                                                    $html .= "</select> ";
                                                    $html .= "<input type='number' name='Quantidade[]' id='Quantidade$linha' onkeyup='verificaTotal($linha);' class='form-control col-md-2 inteiro' maxlength='999' minlength='1' value='{$itensp['Quantidade']}'/> ";
                                                    $html .= "<input type='text' disabled id='VlTotal$linha' class='form-control col-md-2' placeholder='Vl. Total' value='" . number_format($itensp['total'], 2, ',', '') . "'/> ";
                                                    $html .= "<div class='col-md-2'>";
                                                    $html .= "<button class='btn btn-primary' onclick='adicionarLinha($proxLinha)'>+</button> ";
                                                    $html .= "<button class='btn btn-danger' onclick='removerLinha($linha)'>-</button> ";
                                                    $html .= "</div>";
                                                    $html .= "</div>";
                                                    $linha++;
                                                }
                                                echo $html;
                                            }
                                        }
                                        ?>                                        
                                    </div>
                                    <br>
                                    <div class="row col-md-12">
                                        <button type="button" id="btSalvarPedido" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                            <div id="menu1" class="container-fluid tab-pane fade"><br>
                                <h3>Procurar Pedidos</h3>
                                <form method="post" id="fppedido" onsubmit="return false;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome cliente</label>
                                            <input type="text" class="form-control" maxlength="100" placeholder="Digite Nome" name="NomeCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CPF</label>
                                            <input type="text" class="form-control" maxlength="11" placeholder="Digite CPF" name="CPF">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Num. Pedido</label>
                                            <input type="text" class="form-control" placeholder="Digite Num. Pedido" name="NumPedido">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><i class="far fa-calendar"></i> Dt. inicio Pedido</label>
                                            <input type="date" class="form-control" placeholder="00/00/0000" name="data1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><i class="far fa-calendar"></i> Dt. fim. Pedido</label>
                                            <input type="date" class="form-control" placeholder="00/00/0000" name="data2">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" id="btProcurarPedido" class="btn btn-primary">Procurar</button>
                                        <button type="button" id="btExcluirTudo" class="btn btn-danger" style="display: none">Excluir Selecionados</button>
                                    </div>
                                </form>
                                <br>
                                <div class="row col-md-12 listagem" id="listagemPedido">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        
        <div class="modal" id="mItensPedidos">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Listagem de itens pedidos</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include "javascriptGeral.php"; ?>
        <script src="./js/Pedido.js"></script>
        <script>
                                    var CodCliente = '<?= $pedidop['CodCliente'] ?>';
        </script>
    </body>
</html>
