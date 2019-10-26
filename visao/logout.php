<?php

// Inicializa a sessão.
// Se estiver sendo usado session_name("something"), não esqueça de usá-lo agora!
session_start();

// Apaga todas as variáveis da sessão
$_SESSION = array();

// Por último, destrói a sessão
session_destroy();

echo '<script>location.href="/";</script>';