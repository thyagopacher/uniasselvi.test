<?php
include "validaSessao.php";
if(isset($_GET['CodCliente']) && $_GET['CodCliente'] != NULL && $_GET['CodCliente'] != ""){
    $conexao = new Conexao();
    $cliente = new Cliente($conexao);
    $clientep = $cliente->procurarCodigo($_GET['CodCliente']);
}else{
    $clientep = NULL;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes</title>
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
                        <h2>Cliente</h2>
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
                                <h3>Cadastro de Clientes</h3>
                                <form method="post" id="fcliente" onsubmit="return false;">
                                    <input type="hidden" name="CodCliente" value="<?=$clientep['CodCliente']?>">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" id="NomeCliente" maxlength="100" minlength="100" placeholder="Digite Nome" name="NomeCliente" required value="<?=$clientep['NomeCliente']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" class="form-control" id="Email" maxlength="50" placeholder="Digite Email" name="Email" required value="<?=$clientep['Email']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CPF</label>
                                            <input type="email" class="form-control" id="CPF" maxlength="11" minlength="11" placeholder="Digite CPF" name="CPF" required value="<?=$clientep['CPF']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Senha (* Só digite a senha caso queira trocar a anterior.)</label>
                                            <input type="password" class="form-control" id="pwd" maxlength="50" placeholder="Digite Senha" name="Senha" required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" id="btSalvarCliente" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                            <div id="menu1" class="container-fluid tab-pane fade"><br>
                                <h3>Procurar Clientes</h3>
                                <form method="post" id="fpcliente" onsubmit="return false;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" placeholder="Digite Nome" name="NomeCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" class="form-control" placeholder="Digite Email" name="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CPF</label>
                                            <input type="email" class="form-control" placeholder="Digite CPF" name="CPF">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" id="btProcurarCliente" class="btn btn-primary">Procurar</button>
                                    </div>
                                </form>
                                <br>
                                <div class="row col-md-12 listagem" id="listagemCliente"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>        

        <?php include "javascriptGeral.php"; ?>
        <script src="./js/Cliente.js"></script>
    </body>
</html>
