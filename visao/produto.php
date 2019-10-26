<?php
include "validaSessao.php";
if(isset($_GET['CodProduto']) && $_GET['CodProduto'] != NULL && $_GET['CodProduto'] != ""){
    $conexao = new Conexao();
    $produto = new Produto($conexao);
    $produtop = $produto->procurarCodigo($_GET['CodProduto']);
}else{
    $produtop = NULL;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Produtos</title>
        <?php include "cssGeral.php"; ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <?php include "./menuLateral.php"; ?>               
                </div>
                <div class="col-md-10">
                    <div class="container-fluid">
                        <h2>Produto</h2>
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
                                <h3>Cadastro de Produtos</h3>
                                <form method="post" id="fproduto" onsubmit="return false;">
                                    <input type="hidden" name="CodProduto" value="<?= $produtop['CodProduto'] ?>">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" id="NomeProduto" maxlength="100" minlength="100" placeholder="Digite Nome" name="NomeProduto" required value="<?= $produtop['NomeProduto'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> <i class="far fa-money-bill-alt"></i> Vl. Unitário</label>
                                            <input type="text" class="form-control real" id="ValorUnitario" placeholder="Digite Vl. Unitário" name="ValorUnitario" required value="<?= $produtop['ValorUnitario'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-barcode"></i> Cod. Barras</label>
                                            <input type="text" class="form-control" id="CodBarras" maxlength="20" placeholder="Digite Cod. Barras" name="CodBarras" required value="<?= $produtop['CodBarras'] ?>">
                                        </div>
                                    </div>
                     
                                    <div class="col-md-12">
                                        <button type="button" id="btSalvarProduto" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                            <div id="menu1" class="container-fluid tab-pane fade"><br>
                                <h3>Procurar Produtos</h3>
                                <form method="post" id="fpproduto" onsubmit="return false;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" placeholder="Digite Nome" name="NomeProduto">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vl. Unitário</label>
                                            <input type="text" class="form-control real" placeholder="Digite vl. unitário" name="ValorUnitario">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cod. Barras</label>
                                            <input type="text" class="form-control" placeholder="Digite Cod. Barras" name="CodBarras">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button type="button" id="btProcurarProduto" class="btn btn-primary">Procurar</button>
                                    </div>
                                </form>
                                <br>
                                <div class="row col-md-12 listagem" id="listagemProduto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <?php include "javascriptGeral.php"; ?>
        <script src="./js/Produto.js"></script>
    </body>
</html>
