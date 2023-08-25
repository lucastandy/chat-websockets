<?php

session_start(); // Serve para iniciar a sessão
ob_start(); // Limpar o buffer de saída para evitar erro de redirecionamento

// Verificando se as variáveis sessions estão criadas
if (!isset($_SESSION['usuario_id']) or !isset($_SESSION['nome'])) {
    $_SESSION['msg'] = "<p class='alert-erro'>Erro: Necessário realizar o login para acessar a página!</p>";
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucas - WebSocket</title>
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
    <div class="container">
        <div class="conteudo-chat">
            <div class="header-chat">
                <div class="usuario-dados">
                    <img src="api/imagens/celke.jpg" class="img-usuario" alt="<?php echo $_SESSION['nome']; ?>">
                    <div class="nome-usuario" id="nome-usuario"><?php echo $_SESSION['nome']; ?></div>
                </div>
                <div class="sair">
                    <a href="sair.php" class="btn-sair">Sair</a>
                </div>
            </div>
            <div class="chat-box" id="chatBox">
                <span id="mensagem-chat"></span>
            </div>
            <form class="enviar-msg">
                <!-- Campo oculto com o id do usuário -->
                <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">

                <!-- Campo para o usuário digitar a nova mensagem -->
                <input type="text" name="mensagem" id="mensagem" class="campo-msg" placeholder="Mensagem...">
                <input type="button" name="btnEnviar" class="btn-enviar-msg" onclick="enviar()" value="Enviar">

            </form>
        </div>
    </div>

    <script src="js/custom.js"></script>

</body>

</html>