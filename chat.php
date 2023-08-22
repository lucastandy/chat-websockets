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
            <div class="chat-box" id="chatbox">
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
            mensagemChat.insertAdjacentHTML('beforeend', `<div class="msg-recebida">
                    <div class="det-msg-recebida">
                        <p class="texto-msg-recebida">${resultado.nome}: ${resultado.mensagem}</p>
                    </div>
                </div>`);

            // Role para o final após adicionar as mensagens
            scrollBottom();

        }

        // Função responsável em enviar a mensagem
        const enviar = () => {
            // Recupera o id do campo mensagem
            let mensagem = document.getElementById("mensagem");

            let nomeUsuario = document.getElementById("nome-usuario").textContent;

            // Recuperar o id do usuário
            let usuarioId = document.getElementById("usuario_id").value;

            if (usuarioId === "") {
                alert("Erro: Necessário realizar o login para acessar a página!");
                window.location.href = "index.php";
                return;
            }

            // Criar o array de dados para enviar para Websocket
            let dados = {
                mensagem: `${mensagem.value}`,
                usuario_id: usuarioId,
                nome: nomeUsuario
            }

            // Enviar a mensagem para websocket
            ws.send(JSON.stringify(dados));

            // Enviar a mensagem para o HTML, inserir no final da lista de mensagens
            mensagemChat.insertAdjacentHTML('beforeend', `<div class="msg-enviada">
                    <div class="det-msg-enviada">
                        <p class="texto-msg-enviada">${nomeUsuario}: ${mensagem.value}</p>
                    </div>
                </div>`);

            // Limpar o campo mensagem
            mensagem.value = '';

            // Role para o final após adicionar as mensagens
            scrollBottom();
        }


        function scrollBottom() {
            var chatbox = document.getElementById("chatbox");
            chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>

</body>

</html>