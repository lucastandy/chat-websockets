# Projeto Chat com WebSocket usando Ratchet e PHP

# Sobre o projeto
Este projeto foi desenvolvido com base em uma série de tutoriais do canal da Celke, no YouTube.
Esta aplicação simula o chat entre dois usuários. As mensagens são salvas em um banco de dados toda vez que um dos usuário envia a mensagem.

# Layout da aplicação
Tela de Login:

![Login da aplicação](https://github.com/lucastandy/chat-websockets/blob/main/assets/login_do_chat.png)

Chat da aplicação:

![Chat da aplicação](https://github.com/lucastandy/chat-websockets/blob/main/assets/chat.png)

# Tecnlogias Utizadas:

## Back end
* PHP;
* Javascript;
* Mysql (Banco de dados)

## Front end
* HTML;
* CSS;

# Como rodar o projeto
OBS: antes de rodar o projeto, crie o banco de dados com o arquivo bd.sql presente neste repositório.
### A instrução abaixo verifica se o Composer está instalado:
`composer`

### Instalar todas as dependencias indicada pelo package.json:
`composer install`

# Rodar o projeto com PHP
### Para executar o projeto é necessário acessar o diretório api através do terminal ou prompt de comando e digitar a seguinte instrução:
`php servidor_chat.php`

# Sequência para criar o projeto do Zero
## Verificar se o composer está instalado:
`composer`

## Instalar a dependencias Ratchet, biblioteca PHP que permite criar aplicativos de tempo real baseados em WebSockets
`composer require cboden/ratchet`

## Depois é só executar o projeto com o comando:
`php servidor_chat.php`

# Autor
Lucas Tandy do Nascimento Silva.

https://www.linkedin.com/in/lucas-tandy/
