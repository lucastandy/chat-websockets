<?php

session_start(); // Serve para iniciar a sessão
ob_start(); // Limpar o buffer de saída para evitar erro de redirecionamento

include_once './conexao.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tandy - Chat</title>
</head>

<body>
    <h1>Acessar o Chat</h1>

    <?php
    // Exemplo criptografar a senha
    //echo password_hash('123456', PASSWORD_DEFAULT);

    // Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Acessa o If quando o usuário clicar no botão acessar do formulário
    if (!empty($dados['acessar'])) {
        //var_dump($dados);

        // Recuperar os dados do usuário no banco de dados
        $queryUsuario = "SELECT id, nome, usuario, senha_usuario FROM usuarios WHERE usuario =:usuario LIMIT 1";

        // Preparar a QUERY
        $resultUsuario = $conn->prepare($queryUsuario);

        // Substituir o link da query pelo valor que vem do formulário
        $resultUsuario->bindParam(':usuario', $dados['usuario']);

        // Executar a QUERY
        $resultUsuario->execute();

        // Acessa o if quando encontrar usuário no banco de dados
        if (($resultUsuario) and ($resultUsuario->rowCount() != 0)) {
            // Ler o registro retornando do banco de dados
            $rowUsuario = $resultUsuario->fetch(PDO::FETCH_ASSOC);

            // Acessa o if quando a senha é válida
            if (password_verify($dados['senha_usuario'], $rowUsuario['senha_usuario'])) {
                // Cria a sessão e atribui o nome do usuário
                $_SESSION['usuario_id'] = $rowUsuario['id'];
                $_SESSION['nome'] = $rowUsuario['nome'];

                // Redirecionar para o chat
                header("Location: chat.php");
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
        }
    }

    // Verificar se existe a variável msg
    if (isset($_SESSION['msg'])) {
        // Imprimir o valor da variável global
        echo $_SESSION['msg'];
        // Apagar o valor da variável global
        unset($_SESSION['msg']);
    }


    ?>

    <form method="POST" action="">
        <label>Nomes: </label>
        <input type="text" name="usuario" placeholder="Digite o nome">
        <br><br>
        <label>Senha: </label>
        <input type="password" name="senha_usuario" placeholder="Digite a senha">
        <br><br>

        <input type="submit" name="acessar" value="Acessar"><br><br>

    </form>

</body>

</html>