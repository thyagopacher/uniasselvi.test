<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php include "cssGeral.php"; ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <h5 class="card-title text-center"><i class="fas fa-lock"></i> Autenticar</h5>
                            <form id="fLogin" method="post" onsubmit="return false;" class="form-signin">
                                <div class="form-label-group">
                                    <label for="inputEmail">E-mail</label>
                                    <input type="email" name="Email" id="Email" class="form-control" placeholder="Digite e-mail" required autofocus>
                                </div>
                                <div class="form-label-group">
                                    <label for="inputPassword">Senha</label>
                                    <input type="password" name="Senha" id="Senha" class="form-control" placeholder="Digite senha" required>
                                </div>
                                <br>
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" id="btLogin" type="submit">Entrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <?php include "javascriptGeral.php"; ?>
        <script src="./js/Login.js"></script>
    </body>
</html>
