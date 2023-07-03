<?php

session_start(); // Serve para iniciar a sessão
ob_start(); // Limpar o buffer de saída para evitar erro de redirecionamento

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucas - WebSocket</title>
</head>

<body>
    <h2>Chat</h2>

    <!-- Imprimir o nome do usuário que está ne sessão -->
    <p>Bem-vindo <span id="nome-usuario"><?php echo $_SESSION['usuario'] ?></span></p>


    <!-- Campo para o usuário digitar a nova mensagem -->
    <label>Nova mensagem: </label>
    <input type="text" name="mensagem" id="mensagem" placeholder="Digite a mensagem">
    <br><br>
    <input type="button" onclick="enviar()" value="Enviar">
    <br><br>

    <!-- Receber as mensagens do chat enviado pelo JavaScript -->
    <span id="mensagem-chat"></span>

    <script>
        // Recuperar o id que deve receber as mensagens do chat
        const mensagemChat = document.getElementById("mensagem-chat");

        // Endereço do websocket
        const ws = new WebSocket('ws://localhost:8085');

        // Realizar a conexão com websocket
        ws.onopen = (e) => {
            console.log('Conectado!');
        }

        // Receber a mensagem do WebSocket
        ws.onmessage = (mensagemRecebida) => {
            // Ler as mensagens enviada pelo WebSocket
            let resultado = JSON.parse(mensagemRecebida.data);

            // Enviar a mensagem para o HTML, inserir no final da lista de mensagens
            mensagemChat.insertAdjacentHTML('beforeend', `${resultado.mensagem} <br>`);



        }

        // Função responsável em enviar a mensagem
        const enviar = () => {
            // Recupera o id do campo mensagem
            let mensagem = document.getElementById("mensagem");

            let nomeUsuario = document.getElementById("nome-usuario").textContent;

            // Criar o array de dados para enviar para Websocket
            let dados = {
                mensagem: `${nomeUsuario}:  ${mensagem.value}`
            }

            // Enviar a mensagem para websocket
            ws.send(JSON.stringify(dados));

            // Enviar a mensagem para o HTML, inserir no final da lista de mensagens
            mensagemChat.insertAdjacentHTML('beforeend', `${nomeUsuario}: ${mensagem.value} <br>`);

            // Limpar o campo mensagem
            mensagem.value = '';


        }
    </script>



</body>

</html>