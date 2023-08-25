
/************ ENVIAR E RECEBER MENSAGENS ********/

// Recuperar o id que deve receber as mensagens do chat
const mensagemChat = document.getElementById("mensagem-chat");

// Endereço do websocket
const ws = new WebSocket('ws://localhost:8085');

// Realizar a conexão com websocket
ws.onopen = (e) => {
    //console.log('Conectado!');
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
    var chatbox = document.getElementById("chatBox");
    chatbox.scrollTop = chatbox.scrollHeight;
}


/************ LISTAR AS MENSAGENS DO BANCO DE DADOS ********/

// Quantidade de registros carregados
var offset = 0;

// Mover para o scroll para o final
var rolefinal = true;

// Variável de controle para evitar carregamentos simultâneos
var carregandoRegistros = false;

// Função que verifica se o usuário está a 10 pixels do topo
function verificarScroll() {
    var chatBox = document.getElementById("chatBox");

    // Verifica se o usuário está a 10 pixels do topo
    if (chatBox.scrollTop <= 10) {
        console.log("Usuário está próximo ao topo.");
        // Função que carrega as mensagens
        carregarMsg();
    }

}

// Adicionando o ouvinte de eventos de scroll
chatBox.addEventListener('scroll', verificarScroll);

// Função responsável em carregar as mensagens do banco de dados
async function carregarMsg() {

    // Verificando se tá carregando
    if(carregandoRegistros){
        // Se já estiver carregando registros, retorna para evitar carregamentos simultâneos
        return; // Não continue o processamento

    }
    // Atualiza a variável de controle para indicar que está carregando registros
    carregandoRegistros = true;
    
    // Desativa temporariamente o evento de scroll durante o carregamento
    chatBox.onscroll = null;

    // Chama o arquivo PHP responsável em recuperar usuários do banco de dados
    var dados = await fetch(`listar_registros.php?offset=${offset}`);

    // Ler os dados retornado do PHP
    var resposta = await dados.json();
    //console.log(resposta);

    // Acessa o IF quando o arquivo PHP retornar status TRUE
    if (resposta['status']) {
        // Somar a quantidade de registro recuperado
        offset += resposta['qtd_mensagens'];
        
        // Ler as mensagens e enviar para o chat
        resposta['dados'].map(item => {

            // Recuperar o id do usupario
            var usuario_id = document.getElementById('usuario_id').value;

            if (usuario_id == item.usuario_id) {
                // Enviar a mensagem para o HTML
                mensagemChat.insertAdjacentHTML('afterbegin', `<div class="msg-enviada"><div class="det-msg-enviada"><p class="texto-msg-enviada">${item.nome}: ${item.mensagem}</p></div></div>`);
            } else {
                // Enviar a mensagem para o HTML
                mensagemChat.insertAdjacentHTML('afterbegin', `<div class="msg-recebida"><div class="det-msg-recebida"><p class="texto-msg-recebida">${item.nome}: ${item.mensagem}</p></div></div>`);
            }
        });

        // Atualiza a variável de controle para indicar que não está mais carregando registros
        carregandoRegistros = false;
        
        // Reativar o evento de scroll apó o carregamento
        chatBox.onscroll = verificarScroll;

        if(rolefinal){
            rolefinal = false;
            // Role para o final após adicionar as mensagens
            scrollBottom();
        }

    } else {
        // Enviar a mensagem para o HTML
        mensagemChat.insertAdjacentHTML('afterbegin', `<p style='color: #f00'>${resposta['msg']}</p>`);
    }


}

// Carregar as mensagens inicialmente
carregarMsg();