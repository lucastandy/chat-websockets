<?php

session_start(); // Serve para iniciar a sessão
ob_start(); // Limpar o buffer de saída para evitar erro de redirecionamento

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
    // Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Acessa o If quando o usuário clicar no botão acessar do formulário
    if(!empty($dados['acessar'])){
        //var_dump($dados);
        
        // Cria a sessão e atribui o nome do usuário
        $_SESSION['usuario'] = $dados['usuario'];

        // Redirecionar para o chat
        header("Location: chat.php");

    }


    ?>

    <form method="POST" action="">
        <label>Nomes: </label>
        <input type="text" name="usuario" placeholder="Digite o nome">
        <br><br>

        <input type="submit" name="acessar" value="Acessar"><br><br>

    </form>
    
</body>
</html>